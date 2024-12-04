import os

class Config:
    SQLALCHEMY_DATABASE_URI = 'sqlite:///tracking.db'  # Ganti dengan database yang digunakan, misalnya MySQL
    SQLALCHEMY_TRACK_MODIFICATIONS = False
    SECRET_KEY = os.urandom(24)
