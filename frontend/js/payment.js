// Draws the QR code and checks every 2 seconds if the phone has paid.
var qrBox = document.getElementById("qr-box");
var scanUrl = qrBox.getAttribute("data-url");
var inquiryId = qrBox.getAttribute("data-id");

// 1. Draw the QR code (the library is in js/qrcode.js)
var qr = qrcode(0, "M");
qr.addData(scanUrl);
qr.make();
qrBox.innerHTML = qr.createSvgTag(6, 0);

// 2. Ask payment_status.php if the payment is done
function checkPayment() {
  fetch("payment_status.php?id=" + inquiryId)
    .then(function (response) { return response.json(); })
    .then(function (data) {
      if (data.status === "Paid") {
        clearInterval(timer);
        document.getElementById("pay-area").style.display = "none";
        document.getElementById("paid-area").style.display = "block";
      }
    });
}
var timer = setInterval(checkPayment, 2000);
