from flask import render_template, request, redirect
from app.models import Tracking
from app.database import db
from app import app

# Halaman utama
@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        resi = request.form['resi']
        return redirect(f'/tracking/{resi}')
    return render_template('index.html')

# Endpoint untuk pelacakan berdasarkan resi
@app.route('/tracking/<resi>', methods=['GET'])
def get_tracking(resi):
    tracking = Tracking.query.filter_by(resi=resi).first()

    if tracking is None:
        return render_template('tracking_result.html', found=False, resi=resi)

    return render_template('tracking_result.html', found=True, tracking=tracking)
