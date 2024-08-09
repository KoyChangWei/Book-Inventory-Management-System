document.addEventListener('DOMContentLoaded', () => {
    const rows = document.querySelectorAll('tr[data-stock-in][data-stock-out]');

    rows.forEach(row => {
        const stockInDate = new Date(row.getAttribute('data-stock-in'));
        let stockOutDate = row.getAttribute('data-stock-out');
        let countdownDate = new Date(stockOutDate === '0000-00-00 00:00:00' ? stockInDate : stockOutDate);
        const oneYearLater = new Date(countdownDate);
        oneYearLater.setFullYear(countdownDate.getFullYear() + 1);
        const statusCell = row.querySelector('.status');

        const updateCountdown = () => {
            const now = new Date();
            const distance = oneYearLater - now;

            if (distance < 0) {
                statusCell.innerHTML = "Not Active<br>EXPIRED";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            statusCell.innerHTML = `Active<br>${days}d ${hours}h ${minutes}m ${seconds}s`;
        };

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});