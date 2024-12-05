const axios = require('axios');

// API URL untuk mendapatkan data pemesanan berdasarkan ID
const API_ORDER_URL = process.env.API_ORDER_URL || 'https://api.dari kelomppok3.com/orders/'; 

// Fungsi untuk mengambil data pemesanan berdasarkan ID
const getOrderData = async (orderId) => {
  try {
    const response = await axios.get(`${API_ORDER_URL}${orderId}`);
    return response.data;
  } catch (error) {
    throw new Error('Gagal mengambil data pemesanan');
  }
};

module.exports = { getOrderData };
