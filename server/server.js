require('dotenv').config(); // Memuat variabel dari .env

const express = require('express');
const bodyParser = require('body-parser');
const cors = require('cors');
const orderService = require('./services/orderService');
const courierService = require('./services/courierService');

const app = express();
const port = process.env.PORT || 5000;

app.use(cors());
app.use(bodyParser.json());

// Endpoint untuk cek pelacakan
app.post('/api/track', async (req, res) => {
  const { orderId } = req.body;

  try {
    // Ambil data pemesanan berdasarkan ID
    const orderData = await orderService.getOrderData(orderId);

    // Ambil data pelacakan kurir berdasarkan tracking_id
    const trackingData = await courierService.getTrackingData(orderData.tracking_id);

    // Gabungkan data order dan tracking
    const result = {
      order_id: orderData.order_id,
      status: trackingData.status,
      location: trackingData.location,
      update_time: trackingData.update_time,
    };

    res.json(result);
  } catch (error) {
    res.status(500).json({ error: 'Terjadi kesalahan dalam memproses data pelacakan.' });
  }
});

app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});
