<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventory Reports | Everyday Soles</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #090909;
            color: #fff;
            padding: 35px;
        }

        .container {
            max-width: 1450px;
            margin: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 32px;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #aaa;
        }

        .buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        button, .back-btn {
            padding: 12px 18px;
            border: none;
            border-radius: 7px;
            color: white;
            background: #cf1231;
            cursor: pointer;
            text-decoration: none;
            font-weight: bold;
        }

        button:hover, .back-btn:hover {
            background: #a80d27;
        }

        .export-btn {
            background: #16834c;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card, .panel {
            background: #171717;
            border: 1px solid #303030;
            border-radius: 15px;
            padding: 25px;
        }

        .card h3 {
            color: #aaa;
            font-size: 15px;
            margin-bottom: 15px;
        }

        .card h2 {
            font-size: 30px;
        }

        .red {
            color: #ff304d;
        }

        .green {
            color: #00e5a0;
        }

        .report-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 25px;
        }

        .panel h2 {
            font-size: 21px;
            margin-bottom: 20px;
        }

        .report-item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #333;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th {
            background: #292929;
            color: #ff4059;
            text-align: left;
            padding: 16px;
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #333;
        }

        .status {
            background: #741a29;
            color: #ff8a9b;
            padding: 7px 12px;
            border-radius: 20px;
            font-size: 12px;
        }

        .normal {
            background: #164c35;
            color: #6affb8;
        }

        .footer {
            text-align: center;
            color: #777;
            margin-top: 35px;
            font-size: 12px;
        }

        @media(max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }

            .report-grid {
                grid-template-columns: 1fr;
            }
        }

        @media(max-width: 500px) {
            body {
                padding: 15px;
            }

            .cards {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            body {
                background: white;
                color: black;
                padding: 10px;
            }

            .card, .panel {
                background: white;
                color: black;
                border: 1px solid #ccc;
                break-inside: avoid;
            }

            .buttons, .back-btn {
                display: none;
            }

            th {
                background: #eee;
                color: black;
            }

            td {
                border-color: #ccc;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>Inventory Reports</h1>
            <p class="subtitle">
                Everyday Soles - Inventory Management Reports
            </p>
        </div>

        <div class="buttons">

            <button onclick="window.print()">
                Print Report
            </button>

            <button class="export-btn" onclick="exportCSV()">
                Export CSV
            </button>

            <a href="{{ route('home') }}" class="back-btn">
                Back to Dashboard
            </a>

        </div>

    </div>

    <!-- SUMMARY CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Products</h3>
            <h2>{{ $totalProducts }}</h2>
        </div>

        <div class="card">
            <h3>Total Stock Units</h3>
            <h2>{{ $totalStock }}</h2>
        </div>

        <div class="card">
            <h3>Low Stock Products</h3>
            <h2 class="red">
                {{ $lowStockProducts->count() }}
            </h2>
        </div>

        <div class="card">
            <h3>Total Inventory Value</h3>
            <h2 class="green">
                ₱{{ number_format($inventoryValue, 2) }}
            </h2>
        </div>

    </div>

    <!-- BRAND AND CATEGORY REPORTS -->
    <div class="report-grid">

        <div class="panel">

            <h2>Products by Brand</h2>

            @forelse($brandSummary as $brand => $count)

                <div class="report-item">
                    <span>{{ $brand }}</span>
                    <strong>{{ $count }} Products</strong>
                </div>

            @empty

                <p>No brand records available.</p>

            @endforelse

        </div>

        <div class="panel">

            <h2>Stock by Category</h2>

            @forelse($categorySummary as $category => $quantity)

                <div class="report-item">
                    <span>{{ $category }}</span>
                    <strong>{{ $quantity }} Units</strong>
                </div>

            @empty

                <p>No category records available.</p>

            @endforelse

        </div>

    </div>

    <!-- LOW STOCK REPORT -->
    <div class="panel" style="margin-bottom:25px;">

        <h2>Low Stock Report</h2>

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($lowStockProducts as $product)

                        <tr>
                            <td>{{ $product->name }}</td>

                            <td>{{ $product->brand ?? 'N/A' }}</td>

                            <td>{{ $product->category ?? 'N/A' }}</td>

                            <td>{{ $product->quantity }}</td>

                            <td>
                                <span class="status">
                                    Low Stock
                                </span>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5">
                                No low stock products found.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

    </div>

    <!-- COMPLETE PRODUCT INVENTORY -->
    <div class="panel">

        <h2>Complete Product Inventory</h2>

        <div class="table-wrapper">

            <table id="inventoryTable">

                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Stock Value</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>

                            <td>{{ $product->name }}</td>

                            <td>{{ $product->brand ?? 'N/A' }}</td>

                            <td>{{ $product->category ?? 'N/A' }}</td>

                            <td>{{ $product->size ?? 'N/A' }}</td>

                            <td>
                                ₱{{ number_format((float)$product->price, 2) }}
                            </td>

                            <td>{{ $product->quantity }}</td>

                            <td>
                                ₱{{ number_format(
                                    (float)$product->price *
                                    (int)$product->quantity,
                                    2
                                ) }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                No products available.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="footer">
        EVERYDAY SOLES INVENTORY MANAGEMENT SYSTEM © 2026
    </div>

</div>

<script>

function exportCSV() {

    const table = document.getElementById('inventoryTable');

    let csv = [];

    const rows = table.querySelectorAll('tr');

    rows.forEach(row => {

        let columns = row.querySelectorAll('th, td');

        let rowData = [];

        columns.forEach(column => {

            let value = column.innerText
                .replace(/"/g, '""')
                .trim();

            rowData.push('"' + value + '"');

        });

        csv.push(rowData.join(','));

    });

    const csvContent = "\uFEFF" + csv.join("\n");

    const blob = new Blob(
        [csvContent],
        { type: 'text/csv;charset=utf-8;' }
    );

    const link = document.createElement('a');

    const url = URL.createObjectURL(blob);

    link.href = url;
    link.download = 'everyday-soles-inventory-report.csv';

    link.click();

    URL.revokeObjectURL(url);
}

</script>

</body>
</html>
