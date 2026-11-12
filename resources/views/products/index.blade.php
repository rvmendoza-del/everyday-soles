
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Products Management | Everyday Soles</title>

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

h1 { font-size: 30px; }

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

.btn:hover { background: #a50c25; }

.btn-secondary {
    background: #292929;
    border: 1px solid #444;
}

.btn-secondary:hover { background: #444; }

.btn-edit {
    background: #343434;
    padding: 8px 12px;
}

.btn-delete {
    background: #641421;
    padding: 8px 12px;
}

.btn-delete:hover { background: #a50c25; }

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
    font-size: 27px;
    overflow-wrap: anywhere;
}

.card p {
    color: #00d9a0;
    margin-top: 10px;
    font-size: 12px;
}

.panel { margin-bottom: 25px; }

.panel h2 {
    font-size: 20px;
    margin-bottom: 20px;
}

.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 20px;
}

.search {
    width: 320px;
    max-width: 100%;
    padding: 12px;
    border: 1px solid #444;
    background: #242424;
    color: white;
    border-radius: 7px;
    outline: none;
}

.search:focus { border-color: #c8102e; }

.table-wrapper { overflow-x: auto; }

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 950px;
}

th, td {
    padding: 14px;
    text-align: left;
    border-bottom: 1px solid #333;
}

th {
    background: #252525;
    color: #ff4051;
    font-size: 13px;
}

td { color: #ddd; }

tr:hover { background: #222; }

.product-image {
    width: 55px;
    height: 55px;
    object-fit: contain;
    background: #242424;
    border-radius: 7px;
    padding: 4px;
}

.product-name {
    font-weight: bold;
    color: white;
}

.muted {
    color: #888;
    font-size: 12px;
    margin-top: 5px;
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

.actions-cell {
    display: flex;
    gap: 7px;
}

.alert {
    padding: 13px;
    border-radius: 7px;
    margin-bottom: 18px;
    background: #153c28;
    color: #65e6a0;
}

.error-message {
    background: #471b25;
    color: #ff8795;
}

.empty {
    text-align: center;
    color: #888;
    padding: 30px;
}

.footer {
    text-align: center;
    color: #666;
    font-size: 12px;
    padding: 20px;
}

@media(max-width: 950px) {
    .summary { grid-template-columns: repeat(2, 1fr); }
}

@media(max-width: 550px) {
    body { padding: 15px; }
    .summary { grid-template-columns: 1fr; }
    .header { align-items: flex-start; flex-direction: column; }
    .search { width: 100%; }
}

@media print {
    body { background: white; color: black; padding: 10px; }
    .card, .panel { background: white; color: black; }
    .card h2 { color: #c8102e; }
    .actions, .toolbar { display: none; }
}
</style>
</head>

<body>

<div class="container">

    <div class="header">
        <div>
            <h1>Products Management</h1>
            <p class="subtitle">
                Manage your Everyday Soles sneaker inventory.
            </p>
        </div>

        <div class="actions">
            <a href="{{ route('home') }}" class="btn btn-secondary">
                Back to Dashboard
            </a>

            <a href="{{ route('products.create') }}" class="btn">
                + Add New Product
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert error-message">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

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
            <p>Available inventory</p>
        </div>

        <div class="card">
            <h3>Low Stock Products</h3>
            <h2>{{ $lowStockProducts->count() }}</h2>
            <p>5 units or fewer</p>
        </div>

        <div class="card">
            <h3>Total Inventory Value</h3>
            <h2>₱{{ number_format($inventoryValue, 2) }}</h2>
            <p>Price multiplied by quantity</p>
        </div>

    </div>

    <!-- PRODUCTS TABLE -->

    <div class="panel">

        <div class="toolbar">

            <div>
                <h2>Product Inventory</h2>
                <p class="muted">View and manage all registered sneakers.</p>
            </div>

            <input
                type="search"
                id="searchProduct"
                class="search"
                placeholder="Search product, brand, category..."
            >

        </div>

        <div class="table-wrapper">

            <table id="productsTable">

                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Size</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr data-product-row="{{ $product->id }}">

                            <td>
                                @if($product->image)
                                    <img
                                        src="{{ $product->image }}"
                                        class="product-image"
                                        alt="Product image"
                                    >
                                @else
                                    <div class="product-image"></div>
                                @endif
                            </td>

                            <td>
                                <div class="product-name">
                                    {{ $product->name }}
                                </div>
                                <div class="muted">
                                    {{ $product->color ?: 'No color specified' }}
                                </div>
                            </td>

                            <td>{{ $product->brand ?: '-' }}</td>

                            <td>{{ $product->category ?: '-' }}</td>

                            <td>{{ $product->size ?: '-' }}</td>

                            <td>
                                ₱{{ number_format((float)$product->price, 2) }}
                            </td>

                            <td>{{ $product->quantity ?? 0 }}</td>

                            <td>
                                ₱{{ number_format(
                                    (float)$product->price *
                                    (int)($product->quantity ?? 0), 2
                                ) }}
                            </td>

                            <td>
                                @if((int)($product->quantity ?? 0) <= 5)
                                    <span class="stock-badge">
                                        Low Stock
                                    </span>
                                @else
                                    <span class="stock-badge normal-badge">
                                        In Stock
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="actions-cell">

                                    <a
                                        href="{{ route('products.edit', $product->id) }}"
                                        class="btn btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <button
                                        type="button"
                                        class="btn btn-delete"
                                        onclick="deleteProduct(
                                            this,
                                            '{{ route('products.destroy', $product->id) }}',
                                            '{{ addslashes($product->name) }}'
                                        )"
                                    >
                                        Delete
                                    </button>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="10" class="empty">
                                No products available. Click Add New Product to get started.
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

// SEARCH PRODUCTS

document.getElementById('searchProduct').addEventListener('input', function() {

    const search = this.value.toLowerCase();

    document.querySelectorAll('#productsTable tbody tr[data-product-row]')
        .forEach(function(row) {

            row.style.display =
                row.innerText.toLowerCase().includes(search) ? '' : 'none';

        });

});


// DELETE PRODUCT

async function deleteProduct(button, url, productName) {

    if (!confirm('Are you sure you want to delete "' + productName + '"?')) {
        return;
    }

    const originalText = button.textContent;

    button.disabled = true;
    button.textContent = 'Deleting...';

    try {

        const response = await fetch(url, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || 'Unable to delete product.');
        }

        alert(result.message || 'Product deleted successfully!');

        window.location.reload();

    } catch(error) {

        alert(error.message);

        button.disabled = false;
        button.textContent = originalText;

    }

}

</script>

</body>
</html>
