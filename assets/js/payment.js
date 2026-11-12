// Draws the QR code and checks every 2 seconds if the phone has paid.
const qr_box = document.getElementById('qr-box');
const inquiry_id = qr_box.getAttribute('data-id');

const qr = qrcode(0, 'M');
qr.addData(qr_box.getAttribute('data-url'));
qr.make();
qr_box.innerHTML = qr.createSvgTag(6, 0);

function check_payment() {
  fetch('payment_status.php?id=' + inquiry_id)
    .then(function (response) { return response.json(); })
    .then(function (data) {
      if (data.status === 'Paid') {
        clearInterval(timer);
        document.getElementById('pay-area').hidden = true;
        document.getElementById('paid-area').hidden = false;
      }
    })
    .catch(function () {
      // network hiccup, try again on the next tick
    });
}

const timer = setInterval(check_payment, 2000);
