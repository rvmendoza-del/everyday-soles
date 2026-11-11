<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Everyday Soles | Dashboard</title>

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background: #090909;
    color: white;
}

a {
    text-decoration: none;
    color: inherit;
}

button {
    cursor: pointer;
    font: inherit;
}

.app {
    display: flex;
    min-height: 100vh;
}

/* SIDEBAR */
.sidebar {
    width: 270px;
    min-height: 100vh;
    background: #101010;
    border-right: 1px solid #252525;
    padding: 25px 16px;
    display: flex;
    flex-direction: column;
    flex-shrink: 0;
}

.logo {
    text-align: center;
    margin-bottom: 35px;
}

.logo-icon {
    font-size: 42px;
    color: #ff263c;
}

.logo h2 {
    font-size: 23px;
    margin: 7px 0;
}

.logo p {
    font-size: 13px;
    color: #aaa;
}

.nav-title {
    font-size: 11px;
    letter-spacing: 2px;
    color: #777;
    margin: 15px 12px;
}

nav {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

nav a {
    padding: 15px;
    border-radius: 10px;
    color: #ddd;
    font-size: 15px;
    font-weight: bold;
    display: flex;
    gap: 14px;
    align-items: center;
}

nav a:hover,
nav a.active {
    background: #a51022;
    color: white;
}

.nav-icon {
    font-size: 20px;
    width: 25px;
    text-align: center;
}

.sidebar-bottom {
    margin-top: auto;
    text-align: center;
    color: #9d1829;
    font-size: 65px;
    padding-top: 35px;
}

/* MAIN */
.main {
    flex: 1;
    min-width: 0;
    padding: 25px 28px;
}

.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 28px;
    gap: 15px;
}

.header h1 {
    font-size: 30px;
    margin-bottom: 7px;
}

.header p {
    color: #aaa;
    font-size: 15px;
}

.profile {
    position: relative;
}

.profile-button {
    display: flex;
    align-items: center;
    gap: 10px;
    background: none;
    border: 0;
    color: white;
    font-weight: bold;
}

.avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #292929;
    display: grid;
    place-items: center;
    font-size: 20px;
}

.dropdown {
    display: none;
    position: absolute;
    right: 0;
    top: 48px;
    background: #202020;
    border: 1px solid #333;
    border-radius: 10px;
    width: 180px;
    padding: 10px;
    z-index: 10;
}

.dropdown.show {
    display: block;
}

.dropdown a,
.dropdown button {
    display: block;
    width: 100%;
    padding: 12px;
    background: none;
    border: 0;
    text-align: left;
    color: white;
}

.dropdown button {
    color: #ff3549;
}

/* STATISTICS */
.stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 22px;
}

.stat-card {
    background: linear-gradient(140deg, #1a1a1a, #101010);
    border: 1px solid #292929;
    border-radius: 16px;
    padding: 22px;
    display: flex;
    gap: 16px;
    align-items: center;
    min-width: 0;
}

.stat-icon {
    width: 55px;
    height: 55px;
    flex-shrink: 0;
    background: #340e15;
    border-radius: 12px;
    display: grid;
    place-items: center;
    color: #ff3045;
    font-size: 27px;
}

.stat-label {
    font-size: 13px;
    color: #bbb;
    margin-bottom: 10px;
}

.stat-number {
    font-size: 32px;
    font-weight: bold;
    overflow-wrap: anywhere;
}

.stat-change {
    font-size: 12px;
    color: #19d7a0;
    margin-top: 8px;
}

/* PANELS */
.grid-two {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.grid-bottom {
    display: grid;
    grid-template-columns: .9fr 1.2fr;
    gap: 20px;
}

.panel {
    background: linear-gradient(140deg, #171717, #101010);
    border: 1px solid #282828;
    border-radius: 17px;
    padding: 22px;
    min-width: 0;
}

.panel h2 {
    font-size: 19px;
    margin-bottom: 20px;
}

.chart {
    width: 100%;
    height: 230px;
    display: block;
}

.donut-layout {
    display: flex;
    align-items: center;
    justify-content: space-around;
    gap: 15px;
    flex-wrap: wrap;
}

.donut {
    width: 190px;
    height: 190px;
    border-radius: 50%;
    background: #383838;
    position: relative;
    flex-shrink: 0;
}

.donut:after {
    content: "";
    position: absolute;
    inset: 40px;
    background: #171717;
    border-radius: 50%;
}

.donut-center {
    position: absolute;
    inset: 0;
    z-index: 2;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-size: 27px;
    font-weight: bold;
}

.donut-center small {
    font-size: 13px;
    font-weight: normal;
    margin-top: 5px;
    color: #ddd;
}

.legend {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 9px;
    font-size: 13px;
    justify-content: space-between;
}

.legend-name {
    display: flex;
    align-items: center;
    gap: 8px;
}

.dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    display: inline-block;
}

/* TABLE */
.panel-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.panel-heading h2 {
    margin: 0;
}

.view-all {
    color: #ff3448;
    font-size: 13px;
    font-weight: bold;
}

.view-all:hover {
    color: #ff7b87;
    text-decoration: underline;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 560px;
}

th {
    background: #292929;
    text-align: left;
    padding: 14px;
    font-size: 13px;
    color: #ddd;
}

td {
    padding: 15px 12px;
    border-bottom: 1px solid #303030;
    font-size: 13px;
}

.shoe {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: bold;
}

.shoe-icon {
    font-size: 23px;
}

.status {
    background: #721823;
    color: #ffadb4;
    padding: 7px 11px;
    border-radius: 20px;
    font-size: 11px;
}

.status.good {
    background: #144c39;
    color: #8bf0c6;
}

/* FOOTER */
.footer {
    text-align: center;
    color: #666;
    font-size: 11px;
    padding: 25px;
}

/* RESPONSIVE */
@media(max-width:1150px) {
    .stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-bottom {
        grid-template-columns: 1fr;
    }
}

@media(max-width:850px) {
    .sidebar {
        width: 210px;
    }

    .main {
        padding: 20px 15px;
    }

    .grid-two {
        grid-template-columns: 1fr;
    }
}

@media(max-width:600px) {
    .app {
        display: block;
    }

    .sidebar {
        width: 100%;
        min-height: auto;
    }

    .logo {
        margin-bottom: 15px;
    }

    nav {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

    .nav-title,
    .sidebar-bottom {
        display: none;
    }

    .main {
        padding: 20px 12px;
    }

    .header h1 {
        font-size: 23px;
    }

    .stats {
        grid-template-columns: 1fr;
    }

    .stat-card {
        padding: 17px;
    }

    .profile-button .admin-name {
        display: none;
    }
}
</style>
</head>

<body>

<div class="app">

<!-- SIDEBAR -->
<aside class="sidebar">

    <div class="logo">
        <div class="logo-icon">👟</div>
        <h2>Everyday Soles</h2>
        <p>Sneaker Inventory System</p>
    </div>

    <div class="nav-title">MAIN MENU</div>

    <nav>
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'active' : '' }}">
            <span class="nav-icon">▣</span>Dashboard
        </a>

        <a href="{{ route('products.index') }}">
            <span class="nav-icon">▢</span>Inventory
        </a>

        <a href="{{ route('products.create') }}">
            <span class="nav-icon">⊕</span>Add Product
        </a>

        <a href="{{ route('products.index') }}">
            <span class="nav-icon">▤</span>Products
        </a>

        <a href="#analytics">
            <span class="nav-icon">▥</span>Analytics
        </a>

        <a href="#reports">
            <span class="nav-icon">▧</span>Reports
        </a>

        <a href="{{ route('users.index') }}">
            <span class="nav-icon">♙</span>Users
        </a>

        <a href="{{ url('/settings') }}">
            <span class="nav-icon">⚙</span>Settings
        </a>
    </nav>

    <div class="sidebar-bottom">👟</div>

</aside>

<!-- MAIN CONTENT -->
<main class="main">

    <!-- HEADER -->
    <header class="header" id="dashboard">

        <div>
            <h1>Dashboard</h1>
            <p>Overview of your sneaker inventory</p>
        </div>

        <div class="profile">

            <button class="profile-button" onclick="toggleMenu()">
                <span class="avatar">👤</span>
                <span class="admin-name">
                    {{ auth()->user()?->name ?? 'Administrator' }}
                </span>
                <span>⌄</span>
            </button>

            <div class="dropdown" id="profileDropdown">

                <a href="{{ url('/settings') }}">♙ &nbsp; Profile</a>

                @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit">⇥ &nbsp; Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                @endauth

            </div>
        </div>
    </header>

    <!-- STAT CARDS -->
    <section class="stats">

        <div class="stat-card">
            <div class="stat-icon">◇</div>
            <div>
                <div class="stat-label">Total Products</div>
                <div class="stat-number" id="totalProducts">0</div>
                <div class="stat-change">Live inventory count</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">▦</div>
            <div>
                <div class="stat-label">Total Stock Units</div>
                <div class="stat-number" id="totalStock">0</div>
                <div class="stat-change">Live stock quantity</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⚠</div>
            <div>
                <div class="stat-label">Low Stock Products</div>
                <div class="stat-number" id="lowStockCount">0</div>
                <div class="stat-change" style="color:#ff4051">
                    5 units or fewer
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">₱</div>
            <div>
                <div class="stat-label">Inventory Value</div>
                <div class="stat-number" id="inventoryValue">₱0.00</div>
                <div class="stat-change">Price × quantity</div>
            </div>
        </div>

    </section>

    <!-- CHARTS -->
    <section class="grid-two" id="analytics">

        <div class="panel">
            <h2>Stock Overview by Category</h2>
            <svg id="categoryChart"
                 class="chart"
                 viewBox="0 0 600 230"
                 preserveAspectRatio="none">
            </svg>
        </div>

        <div class="panel">
            <h2>Inventory Trend</h2>
            <svg id="trendChart"
                 class="chart"
                 viewBox="0 0 600 230"
                 preserveAspectRatio="none">
            </svg>
        </div>

    </section>

    <!-- BRAND AND LOW STOCK -->
    <section class="grid-bottom" id="reports">

        <div class="panel">
            <h2>Products by Brand</h2>

            <div class="donut-layout">

                <div class="donut">
                    <div class="donut-center">
                        <span id="brandTotal">0</span>
                        <small>Products</small>
                    </div>
                </div>

                <div class="legend" id="brandLegend">
                    <p style="color:#aaa">Loading brand data...</p>
                </div>

            </div>
        </div>

        <div class="panel">

            <div class="panel-heading">
                <h2>Low Stock Report</h2>

                <!-- UPDATED VIEW ALL LINK -->
                <a class="view-all"
                   href="{{ route('products.index') }}">
                    View All
                </a>
            </div>

            <div style="overflow-x:auto">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Brand</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody id="lowStockRows">
                        <tr>
                            <td colspan="4" style="color:#aaa;text-align:center">
                                Loading inventory...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>

    </section>

    <!-- INVENTORY SECTION -->
    <section class="panel" id="inventory" style="margin-top:22px">

        <div class="panel-heading">
            <h2>Inventory Management</h2>
            <a href="{{ route('products.index') }}" class="view-all">
                Manage Products →
            </a>
        </div>

        <p style="color:#aaa;font-size:13px;line-height:1.8">
            Manage your sneaker products, stock quantities, brands,
            categories, and inventory records through the Products
            management page.
        </p>

        <div style="margin-top:18px">
            <a href="{{ route('products.index') }}"
               style="display:inline-block;background:#b41025;padding:12px 18px;border-radius:8px;font-size:13px;font-weight:bold">
                OPEN PRODUCT INVENTORY
            </a>
        </div>

    </section>

    <div class="footer">
        EVERYDAY SOLES INVENTORY MANAGEMENT SYSTEM © 2026
    </div>

</main>
</div>

<script>

/* CURRENCY AND NUMBER */
const peso = value =>
    '₱' + Number(value || 0).toLocaleString('en-PH', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });

const number = value => Number(value || 0);

const colors = [
    '#ff243b',
    '#e33b49',
    '#b65b64',
    '#9a3442',
    '#777',
    '#c47b83'
];

/* SAFE TEXT */
function safeText(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#39;'
    })[char]);
}

/* CATEGORY CHART */
function drawCategoryChart(products) {

    const svg = document.getElementById('categoryChart');
    const groups = {};

    products.forEach(product => {
        const category = product.category || 'Others';

        groups[category] =
            (groups[category] || 0) + number(product.quantity);
    });

    const entries = Object.entries(groups)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 5);

    const max = Math.max(1, ...entries.map(item => item[1]));

    let markup = '';

    [0, 1, 2, 3, 4].forEach(i => {

        const y = 20 + i * 40;

        markup += `
            <line x1="55" y1="${y}" x2="590" y2="${y}"
                stroke="#383838"/>

            <text x="45" y="${y + 4}"
                fill="#ddd"
                font-size="12"
                text-anchor="end">
                ${Math.round(max * (4 - i) / 4)}
            </text>
        `;
    });

    if (!entries.length) {

        markup += `
            <text x="300" y="120"
                fill="#aaa"
                text-anchor="middle">
                No product data yet
            </text>
        `;

    } else {

        const slot = 535 / entries.length;

        entries.forEach((entry, i) => {

            const height = entry[1] / max * 160;
            const x = 55 + i * slot + (slot - 55) / 2;

            markup += `
                <rect x="${x}"
                    y="${180 - height}"
                    width="55"
                    height="${height}"
                    rx="5"
                    fill="#f32237"/>

                <text x="${x + 27}"
                    y="215"
                    fill="#ddd"
                    font-size="12"
                    text-anchor="middle">
                    ${safeText(entry[0].slice(0, 10))}
                </text>
            `;
        });
    }

    svg.innerHTML = markup;
}

/* INVENTORY TREND CHART */
async function drawTrendChart() {

    const svg = document.getElementById('trendChart');

    svg.innerHTML = `
        <text x="300" y="105"
            fill="#aaa"
            text-anchor="middle"
            font-size="14">
            Loading inventory trend...
        </text>
    `;

    try {

        const response = await fetch('/inventory/trend', {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {
            throw new Error(
                `Unable to load inventory trend (HTTP ${response.status}).`
            );
        }

        const snapshots = await response.json();

        if (!Array.isArray(snapshots) || snapshots.length === 0) {

            svg.innerHTML = `
                <text x="300" y="105"
                    fill="#aaa"
                    text-anchor="middle"
                    font-size="14">
                    No inventory snapshots recorded yet.
                </text>
            `;

            return;
        }

        const data = snapshots
            .filter(item => item && item.recorded_at)
            .sort((a, b) =>
                new Date(a.recorded_at) - new Date(b.recorded_at)
            )
            .slice(-10);

        if (data.length === 0) {
            svg.innerHTML = `
                <text x="300" y="105" fill="#aaa"
                    text-anchor="middle">
                    No valid trend data available.
                </text>
            `;
            return;
        }

        const values = data.map(item => number(item.total_stock));
        const maxValue = Math.max(1, ...values);

        const left = 65;
        const right = 575;
        const top = 30;
        const bottom = 175;

        const chartHeight = bottom - top;
        const chartWidth = right - left;

        let markup = '';

        /* GRID LINES */
        for (let i = 0; i <= 4; i++) {

            const y = top + (chartHeight / 4) * i;

            const label = Math.round(
                maxValue - (maxValue / 4) * i
            );

            markup += `
                <line x1="55" y1="${y}"
                    x2="590" y2="${y}"
                    stroke="#383838"/>

                <text x="45" y="${y + 4}"
                    fill="#aaa"
                    font-size="11"
                    text-anchor="end">
                    ${label}
                </text>
            `;
        }

        /* GRAPH POINTS */
        const points = data.map((item, index) => {

            const x = data.length === 1
                ? left + chartWidth / 2
                : left + (chartWidth / (data.length - 1)) * index;

            const y = bottom -
                (number(item.total_stock) / maxValue) * chartHeight;

            return {
                x,
                y,
                value: number(item.total_stock),
                date: item.recorded_at
            };
        });

        const linePoints = points
            .map(point => `${point.x},${point.y}`)
            .join(' ');

        const areaPoints =
            `${left},${bottom} ${linePoints} ` +
            `${points[points.length - 1].x},${bottom}`;

        markup += `
            <polygon points="${areaPoints}"
                fill="#ff243b"
                opacity="0.12"/>

            <polyline points="${linePoints}"
                fill="none"
                stroke="#ff243b"
                stroke-width="3"
                stroke-linecap="round"
                stroke-linejoin="round"/>
        `;

        /* POINT MARKERS */
        points.forEach(point => {

            markup += `
                <circle cx="${point.x}"
                    cy="${point.y}"
                    r="5"
                    fill="#ff243b"
                    stroke="#171717"
                    stroke-width="2">

                    <title>${point.value} stock units</title>
                </circle>
            `;
        });

        /* DATE LABELS */
        const formatDate = value => {

            const date = new Date(value);

            return isNaN(date.getTime())
                ? ''
                : date.toLocaleDateString('en-PH', {
                    month: 'short',
                    day: 'numeric'
                });
        };

        markup += `
            <text x="${left}" y="205"
                fill="#aaa"
                font-size="11"
                text-anchor="start">
                ${safeText(formatDate(points[0].date))}
            </text>

            <text x="${right}" y="205"
                fill="#aaa"
                font-size="11"
                text-anchor="end">
                ${safeText(formatDate(points[points.length - 1].date))}
            </text>
        `;

        if (data.length === 1) {

            markup += `
                <text x="300" y="225"
                    fill="#aaa"
                    font-size="11"
                    text-anchor="middle">
                    A new point will appear after the next inventory change.
                </text>
            `;
        }

        svg.innerHTML = markup;

    } catch (error) {

        console.error(error);

        svg.innerHTML = `
            <text x="300" y="105"
                fill="#ff8b96"
                text-anchor="middle"
                font-size="13">
                ${safeText(error.message)}
            </text>
        `;
    }
}

/* BRAND DONUT CHART */
function drawBrandChart(products) {

    const counts = {};

    products.forEach(product => {

        const brand = product.brand || 'Others';

        counts[brand] = (counts[brand] || 0) + 1;
    });

    const entries = Object.entries(counts)
        .sort((a, b) => b[1] - a[1])
        .slice(0, 6);

    const total = products.length;

    document.getElementById('brandTotal').textContent = total;

    const donut = document.querySelector('.donut');
    const legend = document.getElementById('brandLegend');

    if (!entries.length) {

        donut.style.background = '#383838';

        legend.innerHTML =
            '<p style="color:#aaa">No brand data yet</p>';

        return;
    }

    let position = 0;

    const slices = entries.map((entry, index) => {

        const start = position;

        position += entry[1] / total * 100;

        return `${colors[index % colors.length]} ${start}% ${position}%`;
    });

    donut.style.background =
        `conic-gradient(${slices.join(',')})`;

    legend.innerHTML = entries.map((entry, index) => {

        const percentage = Math.round(
            entry[1] / total * 100
        );

        return `
            <div class="legend-item">

                <span class="legend-name">
                    <i class="dot"
                        style="background:${colors[index % colors.length]}">
                    </i>

                    ${safeText(entry[0])}
                </span>

                <strong>${percentage}%</strong>

            </div>
        `;

    }).join('');
}

/* LOW STOCK REPORT */
function renderLowStock(products) {

    const rows = document.getElementById('lowStockRows');

    const low = products
        .filter(product => number(product.quantity) <= 5)
        .sort((a, b) =>
            number(a.quantity) - number(b.quantity)
        )
        .slice(0, 6);

    if (!low.length) {

        rows.innerHTML = `
            <tr>
                <td colspan="4"
                    style="color:#aaa;text-align:center;padding:20px">
                    No low-stock products. Great work!
                </td>
            </tr>
        `;

        return;
    }

    rows.innerHTML = low.map(product => {

        const quantity = number(product.quantity);

        const status = quantity <= 0
            ? 'Out of Stock'
            : 'Low Stock';

        return `
            <tr>
                <td>
                    <div class="shoe">
                        <span class="shoe-icon">👟</span>
                        ${safeText(product.name || 'Unnamed product')}
                    </div>
                </td>

                <td>${safeText(product.brand || '-')}</td>

                <td>${quantity}</td>

                <td>
                    <span class="status">${status}</span>
                </td>
            </tr>
        `;

    }).join('');
}

/* UPDATE DASHBOARD */
function updateDashboard(products) {

    const totalStock = products.reduce(
        (sum, product) =>
            sum + number(product.quantity), 0
    );

    const lowStock = products.filter(
        product => number(product.quantity) <= 5
    ).length;

    const inventoryValue = products.reduce(
        (sum, product) =>
            sum +
            number(product.price) *
            number(product.quantity),
        0
    );

    document.getElementById('totalProducts').textContent =
        products.length.toLocaleString('en-PH');

    document.getElementById('totalStock').textContent =
        totalStock.toLocaleString('en-PH');

    document.getElementById('lowStockCount').textContent =
        lowStock.toLocaleString('en-PH');

    document.getElementById('inventoryValue').textContent =
        peso(inventoryValue);

    drawCategoryChart(products);
    drawTrendChart();
    drawBrandChart(products);
    renderLowStock(products);
}

/* LOAD PRODUCTS FROM MONGODB THROUGH LARAVEL */
async function loadDashboard() {

    try {

        const response = await fetch('/products/data', {
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        if (!response.ok) {

            throw new Error(
                response.status === 401 || response.status === 403
                    ? 'Please sign in with an authorized admin account to view inventory data.'
                    : `Unable to load products (HTTP ${response.status}).`
            );
        }

        const result = await response.json();

        const products = Array.isArray(result)
            ? result
            : (result.data || []);

        updateDashboard(products);

    } catch (error) {

        console.error(error);

        document.getElementById('lowStockRows').innerHTML = `
            <tr>
                <td colspan="4"
                    style="color:#ff8b96;padding:20px">
                    ${safeText(error.message)}
                </td>
            </tr>
        `;

        document.getElementById('brandLegend').innerHTML = `
            <p style="color:#ff8b96">
                ${safeText(error.message)}
            </p>
        `;
    }
}

/* PROFILE DROPDOWN */
function toggleMenu() {

    document.getElementById('profileDropdown')
        .classList.toggle('show');
}

document.addEventListener('click', function(event) {

    const profile = document.querySelector('.profile');

    if (profile && !profile.contains(event.target)) {

        document.getElementById('profileDropdown')
            .classList.remove('show');
    }
});

/* SIDEBAR ACTIVE LINK */
document.querySelectorAll('nav a[href^="#"]')
    .forEach(function(link) {

        link.addEventListener('click', function() {

            document.querySelectorAll('nav a')
                .forEach(item => {
                    item.classList.remove('active');
                });

            this.classList.add('active');
        });
    });

/* INITIALIZE */
loadDashboard();

</script>

</body>
</html>