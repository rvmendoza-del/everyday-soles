
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Everyday Soles | Inventory</title>
<style>
* { box-sizing: border-box; }
body { margin:0; font-family:Arial,sans-serif; background:#f4f6fa; color:#172033; }
header { background:#172033; color:white; padding:22px 6%; }
header h1 { margin:0; font-size:25px; }
header p { color:#bfc9d8; margin:6px 0 0; }
main { max-width:1200px; margin:auto; padding:32px 20px; }
h2 { margin:0 0 20px; }
.stats { display:grid; grid-template-columns:repeat(3,1fr); gap:18px; }
.card,.panel { background:white; padding:24px; border-radius:12px; box-shadow:0 2px 12px #1720330d; }
.card span { color:#68758a; }
.card strong { display:block; font-size:34px; margin-top:12px; }
.panel { margin-top:25px; overflow-x:auto; }
.toolbar { display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap; }
input,select,textarea { padding:12px; border:1px solid #d7deea; border-radius:8px; width:100%; font:inherit; }
#search { max-width:280px; }
button { background:#172033; color:white; padding:12px 16px; border:0; border-radius:8px; cursor:pointer; }
button:hover { opacity:.85; }
button:disabled { opacity:.5; cursor:wait; }
.edit { background:#2563eb; }
.delete { background:#dc2626; }
.cancel { background:#68758a; }
table { width:100%; border-collapse:collapse; margin-top:18px; }
th,td { padding:14px; text-align:left; border-bottom:1px solid #e8edf3; }
th { background:#f8fafc; color:#68758a; }
.actions { display:flex; gap:6px; }
#message { color:#68758a; }
#notice { margin-top:14px; }
.form-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:14px; }
.form-grid label { display:block; margin-bottom:6px; font-weight:bold; }
.form-actions { display:flex; gap:10px; margin-top:18px; }
.hidden { display:none; }
@media(max-width:650px) {
.stats,.form-grid { grid-template-columns:1fr; }
#search { max-width:100%; }
}
</style>
</head>
<body>

<header>
<h1>EVERYDAY SOLES</h1>
<p>Shoe Inventory Management System</p>
</header>

<main>
<h2>Inventory Dashboard</h2>

<div class="stats">
<div class="card">
<span>Total Products</span>
<strong id="total">0</strong>
</div>
<div class="card">
<span>Total Stock Units</span>
<strong id="stock">0</strong>
</div>
<div class="card">
<span>Low Stock Products (5 or less)</span>
<strong id="low">0</strong>
</div>
</div>

<div class="panel">
<div class="toolbar">
<h2>Products</h2>
<input id="search" placeholder="Search shoes..." oninput="renderProducts()">
<button onclick="showForm()">+ Add Product</button>
</div>
<p id="notice" role="status"></p>
<p id="message">Loading products...</p>

<table>
<thead>
<tr>
<th>Name</th>
<th>Brand</th>
<th>Category</th>
<th>Size</th>
<th>Price</th>
<th>Stock</th>
<th>Actions</th>
</tr>
</thead>
<tbody id="productRows"></tbody>
</table>
</div>

<div class="panel hidden" id="formPanel">
<h2 id="formTitle">Add Product</h2>
<form id="productForm">
<div class="form-grid">

<div>
<label for="name">Shoe Name</label>
<input id="name" required>
</div>

<div>
<label for="brand">Brand</label>
<input id="brand">
</div>

<div>
<label for="category">Category</label>
<select id="category">
<option value="">Select Category</option>
<option>Sneakers</option>
<option>Running Shoes</option>
<option>Basketball Shoes</option>
<option>Casual Shoes</option>
<option>Sandals</option>
<option>Formal Shoes</option>
</select>
</div>

<div>
<label for="size">Size</label>
<input id="size" placeholder="Example: 42">
</div>

<div>
<label for="color">Color</label>
<input id="color">
</div>

<div>
<label for="price">Price (PHP)</label>
<input id="price" type="number" min="0" step="0.01" required>
</div>

<div>
<label for="quantity">Quantity</label>
<input id="quantity" type="number" min="0" step="1" required>
</div>

<div>
<label for="image">Image URL (optional)</label>
<input id="image" placeholder="https://example.com/shoe.jpg">
</div>

</div>

<p><label for="description">Description</label></p>
<textarea id="description" rows="3"></textarea>

<div class="form-actions">
<button type="submit" id="saveButton">Save Product</button>
<button type="button" class="cancel" onclick="hideForm()">Cancel</button>
</div>
</form>
</div>

</main>

<script>
let products = [];
let editingId = null;

const fields = [
'name','brand','category','size','color',
'price','quantity','description','image'
];

function productId(p) {
    const id = p._id ?? p.id;
    if (typeof id === 'string') return id;
    if (id && typeof id === 'object') {
        return id.$oid ?? id.oid ?? null;
    }
    return id == null ? null : String(id);
}

function showForm() {
    editingId = null;
    document.getElementById('productForm').reset();
    document.getElementById('formTitle').textContent = 'Add Product';
    document.getElementById('saveButton').textContent = 'Save Product';
    document.getElementById('formPanel').classList.remove('hidden');
    document.getElementById('formPanel').scrollIntoView({behavior:'smooth'});
}

function hideForm() {
    document.getElementById('formPanel').classList.add('hidden');
    editingId = null;
}

function editProduct(id) {
    const p = products.find(item => productId(item) === id);
    if (!p) return;

    editingId = id;
    fields.forEach(field => {
        document.getElementById(field).value = p[field] ?? '';
    });

    document.getElementById('formTitle').textContent = 'Edit Product';
    document.getElementById('saveButton').textContent = 'Update Product';
    document.getElementById('formPanel').classList.remove('hidden');
    document.getElementById('formPanel').scrollIntoView({behavior:'smooth'});
}

function renderProducts() {
    const search = document.getElementById('search').value.toLowerCase();
    const rows = document.getElementById('productRows');
    rows.replaceChildren();

    const filtered = products.filter(p =>
        String(p.name || '').toLowerCase().includes(search) ||
        String(p.brand || '').toLowerCase().includes(search) ||
        String(p.category || '').toLowerCase().includes(search)
    );

    filtered.forEach(p => {
        const tr = document.createElement('tr');
        const values = [
            p.name, p.brand, p.category, p.size,
            '₱' + Number(p.price || 0).toFixed(2),
            p.quantity
        ];

        values.forEach(value => {
            const td = document.createElement('td');
            td.textContent = value ?? '-';
            tr.appendChild(td);
        });

        const actionTd = document.createElement('td');
        const actions = document.createElement('div');
        actions.className = 'actions';

        const id = productId(p);

        if (id) {
            const edit = document.createElement('button');
            edit.textContent = 'Edit';
            edit.className = 'edit';
            edit.onclick = () => editProduct(id);

            const del = document.createElement('button');
            del.textContent = 'Delete';
            del.className = 'delete';
            del.onclick = () => deleteProduct(id);

            actions.append(edit, del);
        }

        actionTd.appendChild(actions);
        tr.appendChild(actionTd);
        rows.appendChild(tr);
    });

    document.getElementById('message').textContent =
        filtered.length ? '' : 'No products found.';
}

async function loadProducts() {
    try {
        const response = await fetch('/products', {
            headers: {'Accept':'application/json'}
        });

        if (!response.ok) throw new Error('Could not load products');

        const data = await response.json();
        products = Array.isArray(data) ? data : (data.data || []);

        document.getElementById('total').textContent = products.length;
        document.getElementById('stock').textContent =
            products.reduce((sum,p) => sum + Number(p.quantity || 0),0);
        document.getElementById('low').textContent =
            products.filter(p => Number(p.quantity || 0) <= 5).length;

        renderProducts();
    } catch(error) {
        document.getElementById('message').textContent =
            'Error loading products: ' + error.message;
    }
}

async function apiRequest(url, method, body) {
    const response = await fetch(url, {
        method,
        headers: {
            'Accept':'application/json',
            'Content-Type':'application/json',
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
        },
        body:body === undefined ? undefined : JSON.stringify(body)
    });

    if (!response.ok) {
        const error = await response.json().catch(() => ({}));
        const details = error.errors
            ? Object.values(error.errors).flat().join(' ')
            : error.message;
        throw new Error(details || 'Request failed: ' + response.status);
    }

    return response.json();
}

document.getElementById('productForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const data = {};
    fields.forEach(field => {
        data[field] = document.getElementById(field).value;
    });

    data.price = Number(data.price);
    data.quantity = Number(data.quantity);

    const button = document.getElementById('saveButton');
    button.disabled = true;

    try {
        const isEditing = editingId !== null;
        await apiRequest(
            isEditing ? '/products/' + encodeURIComponent(editingId) : '/products',
            isEditing ? 'PUT' : 'POST',
            data
        );

        document.getElementById('notice').textContent =
            isEditing ? 'Product updated successfully!' : 'Product added successfully!';

        hideForm();
        await loadProducts();
    } catch(error) {
        document.getElementById('notice').textContent = 'Error: ' + error.message;
    } finally {
        button.disabled = false;
    }
});

async function deleteProduct(id) {
    if (!confirm('Are you sure you want to delete this product?')) return;

    try {
        await apiRequest('/products/' + encodeURIComponent(id),'DELETE');
        document.getElementById('notice').textContent =
            'Product deleted successfully!';
        await loadProducts();
    } catch(error) {
        document.getElementById('notice').textContent =
            'Error: ' + error.message;
    }
}

loadProducts();
</script>
</body>
</html>
