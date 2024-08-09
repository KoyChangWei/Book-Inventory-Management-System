<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barcode Scanner</title>
    <link rel="stylesheet" href="styles.css">
  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <!-- The sidebar -->
<div class="sidebar">
    <h3 class="sidebar-heading">UUM PRESS BOOK STORE</h3>
    <hr class="sidebar-divider my-0">
    
    <a href="/staff_registration/dashboard.php"><i class="fa fa-fw fa-home"></i> Home</a>
    <h3 class="sidebar-heading">Tables</h3>
    <a href="/book_info/book_info.php"><i class="fa fa-book"></i> Book</a>
    <a href="/stock/stock.php"><i class="fa fa-archive"></i> Stock</a>
</div>
<h1>STOCK-OUT SYSTEM</h1>
    <div class="scanner-container">
        <h2>Scan Barcode to stock-out</h2>
        <input type="text" id="barcode-input" placeholder="Scan barcode">
        <button id="scan-btn">Scan</button>
        <h2>Result</h2>
        <div id="result-container"></div>
    </div>

    <script src="stock-out-script.js"></script>
</body>
</html>
