from flask import Flask
from app.database import db
from app.routes import *


# Inisialisasi aplikasi Flask
app = Flask(__name__)
app.config.from_object('app.config.Config')

# Inisialisasi database
db.init_app(app)
