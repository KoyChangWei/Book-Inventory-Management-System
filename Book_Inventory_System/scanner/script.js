const barcodeInput = document.getElementById('barcode-input');
const scanBtn = document.getElementById('scan-btn');
const resultContainer = document.getElementById('result-container');

scanBtn.addEventListener('click', () => {
    const barcodeValue = barcodeInput.value.trim();
    if (barcodeValue !== '') {
        fetch('process.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `barcode=${barcodeValue}`
        })
        .then(response => response.text())
        .then(data => {
            resultContainer.innerHTML = data;
        })
        .catch(error => {
            console.error(error);
        });
    }
});