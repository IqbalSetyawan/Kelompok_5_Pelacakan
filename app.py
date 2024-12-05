import requests
from flask import Flask, render_template, request, jsonify

app = Flask(__name__)

# URL endpoint API Kelompok 3 untuk mendapatkan data transaksi
GROUP_3_API = "http://url_kelompok3.com/api/transactions"  # Ganti dengan URL API Kelompok 3

# Fungsi untuk mengambil data transaksi berdasarkan nomor resi
def get_transaction_data(resi):
    try:
        # Memanggil API Kelompok 3 untuk mendapatkan data berdasarkan nomor resi
        response = requests.get(f"{GROUP_3_API}?resi={resi}")
        if response.status_code == 200:
            return response.json()
        else:
            return {"error": "Data tidak ditemukan atau resi salah"}
    except Exception as e:
        return {"error": str(e)}

# Halaman utama untuk form cek resi
@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        # Mendapatkan nomor resi dari form
        nomor_resi = request.form.get('resi')
        # Ambil data transaksi berdasarkan nomor resi
        data_transaksi = get_transaction_data(nomor_resi)
        # Jika ada error, tampilkan pesan error
        if 'error' in data_transaksi:
            return render_template('index.html', error=data_transaksi['error'])
        else:
            # Menampilkan data pengiriman
            return render_template('index.html', transaksi=data_transaksi)
    return render_template('index.html')

# API untuk mendapatkan data pelacakan berdasarkan nomor resi
@app.route('/api/pelacakan/<resi>', methods=['GET'])
def api_pelacakan(resi):
    # Ambil data transaksi berdasarkan nomor resi
    data_transaksi = get_transaction_data(resi)
    
    if 'error' in data_transaksi:
        # Jika ada error, kembalikan response dengan status 400
        return jsonify(data_transaksi), 400
    
    # Kembalikan data pelacakan dalam format JSON
    return jsonify(data_transaksi)

if __name__ == '__main__':
    app.run(debug=True)
