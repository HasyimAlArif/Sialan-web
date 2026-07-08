import cv2
from ultralytics import YOLO

# Muat model hasil training
model = YOLO("best.pt")  # pastikan file best.pt ada di folder yang sama

# Buka webcam (0 = webcam default)
cap = cv2.VideoCapture(0)

if not cap.isOpened():
    print("⚠️ Gagal membuka webcam.")
    exit()

print("Tekan 'Q' untuk keluar dari deteksi.")

while True:
    ret, frame = cap.read()
    if not ret:
        print("Gagal membaca frame dari kamera.")
        break

    # Deteksi objek
    results = model(frame)

    # Gambar bounding box hasil deteksi
    annotated_frame = results[0].plot()

    # Tampilkan hasil di jendela
    cv2.imshow("Pothole Detection", annotated_frame)

    # Tekan Q untuk keluar
    if cv2.waitKey(1) & 0xFF == ord('q'):
        break

cap.release()
cv2.destroyAllWindows()
