# 🚗🔍 Automated Number Plate Detection and Vehicle Access Management System

A **real-time vehicle monitoring and access control system** designed for the **Faculty of Science, University of Colombo**.  
The system integrates **YOLOv5 number plate detection, PaddleOCR text recognition, Raspberry Pi, CCTV feeds, and a web-based dashboard** to automate vehicle entry/exit management.

---

## 🎯 Project Highlights

- 🔹 **Live detection** of vehicle number plates at the faculty gate using **CCTV + Raspberry Pi + YOLOv5 (TFLite)**  
- 🔹 **Real-time OCR**: Plate number text extraction using **PaddleOCR**  
- 🔹 **Vehicle classification**: Authorized ✅ vs Unauthorized ❌  
- 🔹 **Web Dashboard (CodeIgniter MVC)**  
  - Live updates of detected vehicles  
  - Role-based access: **Super Admin, Security Officers, Welfare, Dean, Martial Office**  
  - Super Admins can register/manage vehicles and access rights  
- 🔹 **Entry/Exit detection** using plate orientation & color-based logic  
- 🔹 **Secure & centralized** system → replaces manual gate logging  

---

## 🛠️ Technologies Used

- **Computer Vision**
  - YOLOv5 (TensorFlow Lite) – Number plate detection  
  - PaddleOCR – Text recognition  
  - OpenCV – Image preprocessing, frame capture  

- **Hardware**
  - Raspberry Pi – Edge inference + CCTV integration  

- **Software**
  - Flask (Python) – Local API for image processing  
  - CodeIgniter (PHP MVC) – Web-based dashboard  
  - Threaded real-time architecture for smooth frame processing  

- **Other**
  - HTML/JS Dashboard UI  
  - MySQL Database for vehicle records & access control  

---

## ⚙️ System Architecture

1. **Image Capture**  
   - CCTV camera streams video into Raspberry Pi.  

2. **Detection & OCR**  
   - YOLOv5 model detects number plates in frames.  
   - PaddleOCR extracts plate numbers as text.  

3. **Classification**  
   - Check against **authorized vehicle database**.  
   - Mark status → **Authorized / Unauthorized**.  

4. **Access Control**  
   - Detect direction (Entry / Exit).  
   - Apply color-based logic for direction validation.  

5. **Dashboard Integration**  
   - Flask API sends processed results to CodeIgniter web app.  
   - Real-time updates on dashboard with role-based access.  

---

## 📂 Web Dashboard Features

- 📌 **Real-Time Logs** of detected vehicles  
- 📌 **Role-based Authentication**  
  - **Super Admin** → Manage users, vehicles, access rights  
  - **Security Officers** → Monitor entry/exit in real time  
  - **Welfare / Dean / Martial Office** → Limited dashboards for oversight  
- 📌 **Vehicle Management** → Register new vehicles, update/remove existing  
- 📌 **Direction Detection** → Entry/Exit logic applied automatically  

---
## Demo
![plate1](https://github.com/user-attachments/assets/951ba016-2530-4b4c-a978-543276f97f78)
![plate2](https://github.com/user-attachments/assets/9f1a4aff-7ea8-4775-b10e-36ede71965d5)
![plate3](https://github.com/user-attachments/assets/96f157ef-8a9c-4b7b-b4ea-51c91fad76d5)
![plate4](https://github.com/user-attachments/assets/a7063d50-f317-463a-aade-36e33f876be8)


## 🚀 Getting Started

### Requirements
- Raspberry Pi 4 (recommended)  
- Python 3.x  
- YOLOv5 + PaddleOCR environment  
- CodeIgniter (PHP MVC framework)  
- MySQL Database  

### Setup

#### Raspberry Pi (Edge AI Inference)
```bash
# Clone repo
git clone https://github.com/<your-username>/vehicle-access-system.git
cd vehicle-access-system

# Install dependencies
pip install -r requirements.txt

# Run local Flask API
python app.py
