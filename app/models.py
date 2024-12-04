from datetime import datetime
from app.database import db

class Tracking(db.Model):
    id = db.Column(db.Integer, primary_key=True)
    resi = db.Column(db.String(50), unique=True, nullable=False)
    status = db.Column(db.String(100), nullable=False)
    tanggal = db.Column(db.DateTime, default=datetime.utcnow)
    lokasi = db.Column(db.String(100))

    def __repr__(self):
        return f"<Tracking {self.resi}>"
