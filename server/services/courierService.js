const axios = require('axios');

// API URL untuk mendapatkan data pelacakan kurir berdasarkan tracking_id
const API_COURIER_URL = process.env.API_COURIER_URL || 'https://api.courier.com/track'; 

// Fungsi untuk melacak status pengiriman berdasarkan tracking_id
const getTrackingData = async (trackingId) => {
  try {
    const response = await axios.get(`${API_COURIER_URL}?tracking_id=${trackingId}`);
    return response.data;
  } catch (error) {
    throw new Error('Gagal melacak pengiriman');
  }
};

module.exports = { getTrackingData };