document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('tracking-form');
    const inputField = document.getElementById('order-id');
    const resultContainer = document.getElementById('tracking-result');

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        const orderId = inputField.value.trim();

        if (!orderId) {
            alert('Harap masukkan ID Pemesanan');
            return;
        }

        // Menampilkan loading indicator
        resultContainer.innerHTML = 'Memuat...';

        try {
            const response = await fetch('/api/track', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ orderId })
            });
            const data = await response.json();

            if (response.ok) {
                displayResult(data);
            } else {
                resultContainer.innerHTML = `<p>Terjadi kesalahan: ${data.error}</p>`;
            }
        } catch (error) {
            resultContainer.innerHTML = `<p>Terjadi kesalahan. Silakan coba lagi nanti.</p>`;
        }
    });

    const displayResult = (data) => {
        resultContainer.innerHTML = `
            <h3>Hasil Pelacakan</h3>
            <p><strong>Order ID:</strong> ${data.order_id}</p>
            <p><strong>Status Pengiriman:</strong> ${data.status}</p>
            <p><strong>Lokasi:</strong> ${data.location}</p>
            <p><strong>Waktu Update:</strong> ${data.update_time}</p>
        `;
    };
});
