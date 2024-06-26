import sys
import os


# Set the HOME and USERPROFILE environment variables
os.environ['HOME'] = r"C:\Users\User"
os.environ['USERPROFILE'] = r"C:\Users\User"

# Optionally, set the MPLCONFIGDIR to a specific directory to avoid permission issues
os.environ['MPLCONFIGDIR'] = os.path.join(os.environ['HOME'], ".matplotlib")

from ultralytics import YOLO
# Your script continues here


def deteksi_gambar(model_path, image_path):
    try:
        # Load model YOLOv8
        model = YOLO(model_path)
        # Prediksi objek dalam gambar
        results = model(image_path)


        return {
            "results": results,
        }

    except Exception as e:
        # Tangkap exception dan kirim pesan error
        print(f"Error: {str(e)}", file=sys.stderr)
        return None

if __name__ == "__main__":
    if len(sys.argv) != 3:
        sys.exit(1)

    model_path = sys.argv[1]
    image_path = sys.argv[2]

    hasil = deteksi_gambar(model_path, image_path)
    if hasil:
        print(hasil)
    else:
        print({"error": "Failed to process image."})
