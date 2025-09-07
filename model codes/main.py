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
cap = cv2.VideoCapture('new1.mp4')  # Change to your video source
model = YOLO("best_float32.tflite")
with open("coco1.txt", "r") as f:
    class_names = f.read().splitlines()

# Flask app to serve the web application
app = Flask(__name__)
latest_data = None

@app.route("/")
def index():
    return render_template("index.html")

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

# Static area where the number plates are detected (blue polygon)
area = [(-250, 230), (-250, 340), (1250, 328), (1250, 218)]


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
                    print(text)
                    text = text.replace('(', '').replace(')', '').replace(',', '').replace(']', '').replace('-', ' ')

                    # Save to database
                    manage_numberplate_db(text)

                    # Add to vehicle_text_map with the current timestamp
                    vehicle_text_map[track_id] = {'text': text, 'timestamp': time.time()}

    # Display the processed text for vehicles within the 2-second window
    current_time = time.time()
    for track_id in list(vehicle_text_map.keys()):
        vehicle_info = vehicle_text_map[track_id]
        if current_time - vehicle_info['timestamp'] <= 2:
            text = vehicle_info['text']
            # Find the bounding box for the vehicle
            for box, id in zip(boxes, track_ids):
                if id == track_id:
                    x1, y1, _, _ = box
                    # Display the text above the bounding box in green
                    cv2.putText(frame, text, (x1, y1 - 10), cv2.FONT_HERSHEY_SIMPLEX, 0.7, (0, 255, 0), 2)
        else:
            # Remove the track ID if the time exceeds 2 seconds
            del vehicle_text_map[track_id]

    # Draw the static blue rectangle on the frame
    draw_static_rectangle(frame)

    # Update the latest data for Flask to serve
    if len(vehicle_text_map) > 0:
        latest_vehicle = vehicle_text_map[list(vehicle_text_map.keys())[-1]]
        identity_info = check_identity(latest_vehicle['text'])
        latest_data = {
            "numberplate": latest_vehicle['text'],
            "status": identity_info["status"],
            "name": identity_info["name"],
            "post": identity_info["post"]
        }

    # Display the processed frame in a window
    cv2.imshow("Processed Video", frame)

    # Break the loop if 'Esc' key is pressed
    if cv2.waitKey(1) & 0xFF == 27:  # Press 'Esc' to exit
        break

cap.release()
cv2.destroyAllWindows()

