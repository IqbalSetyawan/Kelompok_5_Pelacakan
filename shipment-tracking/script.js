document.getElementById('trackForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const trackingNumber = document.getElementById('trackingNumber').value;
    fetch(`/api/track/${trackingNumber}`)
      .then(response => response.json())
      .then(data => {
        document.getElementById('result').innerHTML = `
          <p>Tracking Number: ${data.tracking_number}</p>
          <p>Status: ${data.status}</p>
          <p>Current Location: ${data.current_location}</p>
          <p>Estimated Delivery: ${data.estimated_delivery}</p>
        `;
      })
      .catch(error => {
        document.getElementById('result').innerHTML = `<p>Error: ${error.message}</p>`;
      });
  });