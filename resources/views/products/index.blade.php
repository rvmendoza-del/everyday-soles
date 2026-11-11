
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Reports | Everyday Soles</title>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

body {
    background: #090909;
    color: white;
    padding: 35px;
}

.container {
    max-width: 1400px;
    margin: auto;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 30px;
}

h1 {
    font-size: 30px;
}

.subtitle {
    color: #aaa;
    margin-top: 8px;
}

.actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    display: inline-block;
    padding: 12px 18px;
    background: #c8102e;
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 7px;
    font-weight: bold;
    cursor: pointer;
}

.btn:hover {
    background: #a50c25;
}

.btn-secondary {
    background: #292929;
    border: 1px solid #444;
}

.btn-secondary:hover {
    background: #444;
}

.summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 25px;
}

.card, .panel {
    background: #171717;
    border: 1px solid #303030;
    border-radius: 12px;
    padding: 23px;
}

.card h3 {
    color: #aaa;
    font-size: 14px;
    margin-bottom: 15px;
}

.card h2 {
    color: #ff4051;
    font-size: 28px;
    overflow-wrap: anywhere;
}

.card p {
    color: #00d9a0;
    margin-top: 10px;
    font-size: 12px;
}

.panel {
    margin-bottom: 25px;
}

.panel h2 {
    font-size: 20px;
    margin-bottom: 20px;
}

.report-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 500px;
}

th, td {
    padding: 14px;
    text-align: left;
    border-bottom: 1px solid #333;
}

th {
    background: #252525;
    color: #ff4051;
}

td {
    color: #ddd;
}

tr:hover {
    background: #222;
}

.table-wrapper {
    overflow-x: auto;
}

.stock-badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    background: #641421;
    color: #ff8795;
    font-size: 12px;
}

.normal-badge {
    background: #124b36;
    color: #64e5ae;
}

.summary-list {
    list-style: none;
}

.summary-list li {
    display: flex;
    justify-content: space-between;
    padding: 13px 0;
    border-bottom: 1px solid #333;
    color: #ddd;
}

.summary-list strong {
    color: #ff4051;
}

.empty {
    color: #888;
    padding: 15px 0;
}

@media(max-width: 950px) {
    .summary {
        grid-template-columns: repeat(2, 1fr);
    }

    .report-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 550px) {
    body {
        padding: 15px;
    }

    .summary {
        grid-template-columns: 1fr;
    }

    .header {
        align-items: flex-start;
        flex-direction: column;
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
    }

    .card h2, .summary-list strong {
        color: #c8102e;
    }

    .card h3, td, .summary-list li {
        color: black;
    }

    .actions, .back-button {
        display: none;
    }

    th {
        background: #eee;
        color: #c8102e;
    }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Inventory Reports</h1>
            <p class="subtitle">
                Everyday Soles | Inventory Performance Overview
            </p>
        </div>

        <div class="actions">
            <button class="btn btn-secondary" onclick="window.print()">
                Print Report
            </button>

            <button class="btn" onclick="exportCSV()">
                Export CSV
            </button>
        </div>
    </div>

    <!-- SUMMARY CARDS -->

    <div class="summary">

        <div class="card">
            <h3>Total Products</h3>
            <h2>{{ $totalProducts }}</h2>
            <p>Registered products</p>
        </div>

        <div class="card">
            <h3>Total Stock Units</h3>
            <h2>{{ number_format($totalStock) }}</h2>
            <p>Available inventory quantity</p>
        </div>

        <div class="card">
            <h3>Low Stock Products</h3>
            <h2>{{ $lowStockProducts->count() }}</h2>
            <p>Products with 5 units or fewer</p>
        </div>

        <div class="card">
            <h3>Total Inventory Value</h3>
            <h2>₱{{ number_format($inventoryValue, 2) }}</h2>
            <p>Price multiplied by quantity</p>
        </div>

    </div>

    <!-- BRAND AND CATEGORY REPORTS -->

    <div class="report-grid">

        <div class="panel">
            <h2>Products by Brand</h2>

            @if($brandSummary->isNotEmpty())
                <ul class="summary-list">
                    @foreach($brandSummary as $brand => $count)
                        <li>
                            <span>{{ $brand }}</span>
                            <strong>{{ $count }} Products</strong>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty">No brand data available.</p>
            @endif
        </div>

        <div class="panel">
            <h2>Stock by Category</h2>

            @if($categorySummary->isNotEmpty())
                <ul class="summary-list">
                    @foreach($categorySummary as $category => $quantity)
                        <li>
                            <span>{{ $category }}</span>
                            <strong>{{ $quantity }} Units</strong>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="empty">No category data available.</p>
            @endif
        </div>

    </div>

    <!-- LOW STOCK REPORT -->

    <div class="panel">
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
                            <td>{{ $product->brand ?: '-' }}</td>
                            <td>{{ $product->category ?: '-' }}</td>
                            <td>{{ $product->quantity ?? 0 }}</td>
                            <td>
                                <span class="stock-badge">
                                    Low Stock
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">
                                No low stock products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- COMPLETE INVENTORY REPORT -->

    <div class="panel">
        <h2>Complete Inventory Report</h2>

        <div class="table-wrapper">
            <table id="inventoryTable">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Total Value</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->brand ?: '-' }}</td>
                            <td>{{ $product->category ?: '-' }}</td>
                            <td>{{ $product->size ?: '-' }}</td>
                            <td>
                                ₱{{ number_format((float) $product->price, 2) }}
                            </td>
                            <td>{{ $product->quantity ?? 0 }}</td>
                            <td>
                                ₱{{ number_format(
                                    (float) $product->price *
                                    (int) ($product->quantity ?? 0), 2
                                ) }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty">
                                No products available.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="actions back-button" style="margin-bottom: 25px;">
        <a href="{{ route('home') }}" class="btn">
            ← Back to Dashboard
        </a>
    </div>

    <p style="text-align:center; color:#666; font-size:12px; margin:25px 0;">
        EVERYDAY SOLES INVENTORY MANAGEMENT SYSTEM © 2026
    </p>

</div>

<script>
function exportCSV() {

    const table = document.getElementById('inventoryTable');

    const rows = Array.from(table.querySelectorAll('tr'));

    const csv = rows.map(row => {
        return Array.from(row.querySelectorAll('th, td'))
            .map(cell => {
                return '"' + cell.innerText.replace(/"/g, '""') + '"';
            })
            .join(',');
    }).join('\n');

    const blob = new Blob(
        ['\uFEFF' + csv],
        { type: 'text/csv;charset=utf-8;' }
    );

    const link = document.createElement('a');

    link.href = URL.createObjectURL(blob);
    link.download = 'everyday-soles-inventory-report.csv';

    document.body.appendChild(link);
    link.click();

    document.body.removeChild(link);
    URL.revokeObjectURL(link.href);
}
</script>

</body>
</html>
