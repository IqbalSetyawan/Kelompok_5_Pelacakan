import requests
import mysql.connector
from datetime import datetime

# API untuk mengambil transaksi
class ProductAPI:
    def __init__(self, server_ip):
        self.base_url = f'http://{server_ip}:5000'
        self.headers = {
            'Content-Type': 'application/json'
        }

    def get_transactions(self):
        try:
            response = requests.get(
                f'{self.base_url}/api/transactions',  # Endpoint API transaksi
                headers=self.headers
            )
            return response.json() if response.status_code == 200 else {'error': 'Unable to fetch transactions'}
        except requests.exceptions.RequestException as e:
            return {'error': f'Connection error: {str(e)}'}

# Fungsi untuk menyimpan transaksi ke database
def save_transactions_to_db(transactions):
    connection = get_db_connection()
    cursor = connection.cursor()

    # Menyimpan setiap transaksi dengan hanya kolom yang diperlukan
    for transaction in transactions:
        cursor.execute("""
            INSERT INTO pembayaran (transaction_id, total_price, created_at)
            VALUES (%s, %s, %s)
            ON DUPLICATE KEY UPDATE
            total_price = VALUES(total_price),
            created_at = VALUES(created_at)
        """, (
            transaction['id'], 
            transaction['total_price'], 
            transaction['created_at']     ))

    connection.commit()
    cursor.close()
    connection.close()

# Fungsi untuk mendapatkan koneksi ke database MySQL
def get_db_connection():
    return mysql.connector.connect(
        host='localhost',         # Ganti dengan host database Anda
        database='pembayaran', # Ganti dengan nama database Anda
        user='root',               # Username MySQL
        password=''                # Password MySQL
    )

# Fungsi utama untuk mengambil dan menyimpan transaksi
def sync_transactions():
    # Memanggil API untuk mendapatkan transaksi
    product_api = ProductAPI(server_ip='192.168.0.122')  # Ganti IP sesuai dengan server API mereka
    transactions_data = product_api.get_transactions()

    if 'error' in transactions_data:
        print(f"Error: {transactions_data['error']}")
    else:
        # Menyimpan transaksi ke database
        save_transactions_to_db(transactions_data)

if __name__ == "__main__":
    sync_transactions()  # Memulai proses sinkronisasi
