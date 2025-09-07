import cv2
from ultralytics import YOLO
from paddleocr import PaddleOCR
import numpy as np
from server_1 import manage_numberplate_db, check_identity
from flask import Flask, jsonify, render_template
import threading
import time

# Initialize PaddleOCR
ocr = PaddleOCR()
cap = cv2.VideoCapture('tc.mp4')  # Change to your video source
model = YOLO("best_float32.tflite")
with open("coco1.txt", "r") as f:
    class_names = f.read().splitlines()

# Flask app to serve the web application
app = Flask(__name__)
latest_data = None

@app.route("/")
def index():
    return render_template("index2.html")

@app.route("/latest")
def latest_data_endpoint():
    global latest_data
    return jsonify(latest_data if latest_data else {})

def start_flask():
    app.run(debug=False, use_reloader=False, port=5000)

flask_thread = threading.Thread(target=start_flask)
flask_thread.daemon = True
flask_thread.start()

def perform_ocr(image_array):
    if image_array is None:
        raise ValueError("Image is None")
    results = ocr.ocr(image_array, rec=True)
    detected_text = []
    if results[0] is not None:
        for result in results[0]:
            text = result[1][0]
            detected_text.append(text)
    return ''.join(detected_text)

def detect_color(image):
    """Detects the dominant color in the cropped region."""
    hsv_image = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)
    mask_white = cv2.inRange(hsv_image, (0, 0, 200), (180, 30, 255))
    mask_yellow = cv2.inRange(hsv_image, (15, 100, 100), (35, 255, 255))
    white_pixels = cv2.countNonZero(mask_white)
    yellow_pixels = cv2.countNonZero(mask_yellow)
    if white_pixels > yellow_pixels:
        return "White"
    elif yellow_pixels > white_pixels:
        return "Yellow"
    return "Unknown"

# Static area where the number plates are detected (blue polygon)
area = [(-50, 180), (-50, 249), (1050, 237), (1050, 168)]
counter = []
vehicle_text_map = {}  # Store text and timestamp for each vehicle ID

# Draw the static blue rectangle (this will stay constant in the frame)
def draw_static_rectangle(frame):
    cv2.polylines(frame, [np.array(area, np.int32)], True, (255, 0, 0), 2)

while True:
    ret, frame = cap.read()
    if not ret:
        break
    frame = cv2.resize(frame, (1020, 500))
    results = model.track(frame, persist=True, imgsz=240)

    if results[0].boxes is not None and results[0].boxes.id is not None:
        boxes = results[0].boxes.xyxy.int().cpu().tolist()
        track_ids = results[0].boxes.id.int().cpu().tolist()

        for box, track_id in zip(boxes, track_ids):
            x1, y1, x2, y2 = box
            cx = int(x1 + x2) // 2
            cy = int(y1 + y2) // 2
            result = cv2.pointPolygonTest(np.array(area, np.int32), (cx, cy), False)
            if result >= 0:
                if track_id not in counter:
                    counter.append(track_id)  # Only add if it's a new track ID

                    crop = frame[y1:y2, x1:x2]
                    crop = cv2.resize(crop, (120, 70))

                    text = perform_ocr(crop)
                    plate_color = detect_color(crop)
                    print(f"Detected: {text}, Color: {plate_color}")

                    text = text.replace('(', '').replace(')', '').replace(',', '').replace(']', '').replace('-', ' ')

                    # Save to database
                    manage_numberplate_db(text)

                    # Add to vehicle_text_map with the current timestamp
                    vehicle_text_map[track_id] = {
                        'text': text,
                        'timestamp': time.time(),
                        'color': plate_color,
                        'direction': 'In' if plate_color == "White" else 'Out'
                    }

    # Update the latest data for Flask to serve
    if len(vehicle_text_map) > 0:
        latest_vehicle = vehicle_text_map[list(vehicle_text_map.keys())[-1]]
        identity_info = check_identity(latest_vehicle['text'])
        latest_data = {
            "numberplate": latest_vehicle['text'],
            "status": identity_info["status"],
            "name": identity_info["name"],
            "post": identity_info["post"],
            "direction": latest_vehicle['direction']  # Adding direction to the response
        }

    # Draw the static blue rectangle on the frame
    draw_static_rectangle(frame)

    # Display the processed frame in a window
    cv2.imshow("Processed Video", frame)

    # Break the loop if 'Esc' key is pressed
    if cv2.waitKey(1) & 0xFF == 27:  # Press 'Esc' to exit
        break

cap.release()
cv2.destroyAllWindows()
