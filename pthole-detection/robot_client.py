# -*- coding: utf-8 -*-
"""
=======================================================
  SIALAN - Robot API Client (Python)
  Integrasi pengiriman laporan dari robot/IoT ke server
=======================================================

Dependensi:
    pip install requests

Cara pakai:
    python robot_client.py
"""

import requests
import os
import sys
import io
from datetime import datetime

# Paksa stdout pakai UTF-8 agar aman di Windows
sys.stdout = io.TextIOWrapper(sys.stdout.buffer, encoding="utf-8", errors="replace")


# =======================================================
#  KONFIGURASI
# =======================================================

API_BASE_URL = "https://semzzdev.qzz.io/api"
ROBOT_TOKEN  = "robot-secret-123"
ROBOT_NAME   = "Robot-01"
ROBOT_NO_HP  = "08000000000"


# =======================================================
#  CLIENT CLASS
# =======================================================

class RobotAPIClient:
    """Client untuk berkomunikasi dengan API SIALAN dari sisi robot."""

    def __init__(self, base_url: str, token: str):
        self.base_url = base_url.rstrip("/")
        self.session  = requests.Session()
        self.session.headers.update({
            "X-Robot-Token": token,
            "Accept": "application/json",
        })

    # ------------------------------------------------------------------
    #  Kirim Laporan (tanpa foto)
    # ------------------------------------------------------------------
    def kirim_laporan(
        self,
        nama_pelapor: str,
        no_hp: str,
        judul: str,
        deskripsi: str,
        latitude: float,
        longitude: float,
        alamat_lokasi: str,
    ) -> dict:
        """
        Kirim laporan baru tanpa foto ke server.

        Returns:
            dict: Response JSON dari server.
        Raises:
            requests.HTTPError: Jika server mengembalikan status error.
        """
        payload = {
            "nama_pelapor":  nama_pelapor,
            "no_hp":         no_hp,
            "judul":         judul,
            "deskripsi":     deskripsi,
            "latitude":      str(latitude),
            "longitude":     str(longitude),
            "alamat_lokasi": alamat_lokasi,
        }

        url = f"{self.base_url}/robot/laporans"
        response = self.session.post(url, data=payload, timeout=15)
        response.raise_for_status()
        return response.json()

    # ------------------------------------------------------------------
    #  Kirim Laporan + Foto
    # ------------------------------------------------------------------
    def kirim_laporan_dengan_foto(
        self,
        nama_pelapor: str,
        no_hp: str,
        judul: str,
        deskripsi: str,
        latitude: float,
        longitude: float,
        alamat_lokasi: str,
        foto_path: str,
    ) -> dict:
        """
        Kirim laporan beserta file foto ke server.

        Args:
            foto_path: Path absolut/relatif ke file gambar (jpeg/png/jpg/webp).

        Returns:
            dict: Response JSON dari server.
        Raises:
            FileNotFoundError: Jika file foto tidak ditemukan.
            requests.HTTPError: Jika server mengembalikan status error.
        """
        if not os.path.isfile(foto_path):
            raise FileNotFoundError(f"File foto tidak ditemukan: {foto_path}")

        payload = {
            "nama_pelapor":  nama_pelapor,
            "no_hp":         no_hp,
            "judul":         judul,
            "deskripsi":     deskripsi,
            "latitude":      str(latitude),
            "longitude":     str(longitude),
            "alamat_lokasi": alamat_lokasi,
        }

        url = f"{self.base_url}/robot/laporans"
        with open(foto_path, "rb") as foto_file:
            ext   = os.path.splitext(foto_path)[1].lower().lstrip(".")
            mime  = f"image/{ext if ext != 'jpg' else 'jpeg'}"
            files = {"foto": (os.path.basename(foto_path), foto_file, mime)}
            response = self.session.post(url, data=payload, files=files, timeout=30)

        response.raise_for_status()
        return response.json()


# =======================================================
#  HELPER - Cetak hasil dengan rapi
# =======================================================

def cetak_hasil(result: dict):
    print("\n" + "=" * 50)
    if result.get("success"):
        print("[OK] LAPORAN BERHASIL DIKIRIM")
        data = result.get("data", {})
        print(f"     ID Laporan : {data.get('id')}")
        print(f"     Judul      : {data.get('judul')}")
        print(f"     Status     : {data.get('status')}")
        print(f"     Waktu      : {data.get('created_at')}")
    else:
        print("[GAGAL] LAPORAN TIDAK TERKIRIM")
        print(f"     Pesan : {result.get('message')}")
        errors = result.get("errors")
        if errors:
            for field, msgs in errors.items():
                print(f"     [{field}] {', '.join(msgs)}")
    print("=" * 50 + "\n")


# =======================================================
#  CONTOH PENGGUNAAN
# =======================================================

def contoh_laporan_tanpa_foto(client: RobotAPIClient):
    """Simulasi robot mendeteksi jalan berlubang dan mengirim laporan."""

    print("\n[INFO] Mengirim laporan tanpa foto...")

    # Data simulasi dari sensor robot
    latitude      = -6.200000
    longitude     = 106.816666
    alamat_lokasi = "Jl. Sudirman No. 1, Jakarta Pusat"
    waktu         = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    result = client.kirim_laporan(
        nama_pelapor  = ROBOT_NAME,
        no_hp         = ROBOT_NO_HP,
        judul         = "Jalan Berlubang Terdeteksi",
        deskripsi     = (
            f"Sensor robot mendeteksi kerusakan jalan pada koordinat "
            f"({latitude}, {longitude}). "
            f"Waktu deteksi: {waktu}."
        ),
        latitude      = latitude,
        longitude     = longitude,
        alamat_lokasi = alamat_lokasi,
    )

    cetak_hasil(result)
    return result


def contoh_laporan_dengan_foto(client: RobotAPIClient, foto_path: str):
    """Simulasi robot mengirim laporan beserta foto dari kamera."""

    print(f"\n[INFO] Mengirim laporan dengan foto: {foto_path}")

    latitude      = -7.250445
    longitude     = 112.768845
    alamat_lokasi = "Jl. Diponegoro No. 99, Surabaya"
    waktu         = datetime.now().strftime("%Y-%m-%d %H:%M:%S")

    result = client.kirim_laporan_dengan_foto(
        nama_pelapor  = ROBOT_NAME,
        no_hp         = ROBOT_NO_HP,
        judul         = "Kerusakan Jalan - Bukti Foto",
        deskripsi     = (
            f"Robot menangkap gambar kerusakan jalan pada koordinat "
            f"({latitude}, {longitude}). "
            f"Waktu deteksi: {waktu}. "
            f"Foto terlampir untuk verifikasi."
        ),
        latitude      = latitude,
        longitude     = longitude,
        alamat_lokasi = alamat_lokasi,
        foto_path     = foto_path,
    )

    cetak_hasil(result)
    return result


# =======================================================
#  MAIN
# =======================================================

if __name__ == "__main__":
    # Inisialisasi client
    client = RobotAPIClient(
        base_url = API_BASE_URL,
        token    = ROBOT_TOKEN,
    )

    # --- Contoh 1: Tanpa Foto ---
    try:
        contoh_laporan_tanpa_foto(client)
    except requests.exceptions.ConnectionError:
        print("[ERROR] Gagal koneksi ke server. Cek jaringan atau URL.")
    except requests.exceptions.HTTPError as e:
        print(f"[ERROR] HTTP {e.response.status_code}: {e.response.text}")
    except Exception as e:
        print(f"[ERROR] {e}")

    # --- Contoh 2: Dengan Foto ---
    # Ganti dengan path foto yang valid sebelum dijalankan
    # foto_path = "foto_jalan.jpg"
    # try:
    #     contoh_laporan_dengan_foto(client, foto_path)
    # except FileNotFoundError as e:
    #     print(f"[ERROR] {e}")
    # except requests.exceptions.HTTPError as e:
    #     print(f"[ERROR] HTTP {e.response.status_code}: {e.response.text}")
    # except Exception as e:
    #     print(f"[ERROR] {e}")
