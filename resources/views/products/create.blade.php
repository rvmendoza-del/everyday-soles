<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Everyday Soles</title>

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
            padding: 40px 20px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .header p {
            color: #aaa;
        }

        .form-card {
            background: #171717;
            border: 1px solid #303030;
            border-radius: 15px;
            padding: 30px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }

        .full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 14px;
            font-weight: bold;
        }

        input, select, textarea {
            width: 100%;
            padding: 13px;
            border-radius: 7px;
            border: 1px solid #444;
            background: #242424;
            color: white;
            outline: none;
        }

        input:focus, select:focus, textarea:focus {
            border-color: #c8102e;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .buttons {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        button, .cancel {
            padding: 13px 22px;
            border: none;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #c8102e;
            color: white;
        }

        button:hover {
            background: #a50c25;
        }

        .cancel {
            background: #333;
            color: white;
        }

        #message {
            margin-top: 18px;
            color: #ff6575;
        }

        @media(max-width: 600px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>＋ Add New Product</h1>
        <p>Add a new sneaker to your Everyday Soles inventory.</p>
    </div>

    <div class="form-card">

        <form id="productForm"
              action="{{ route('products.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-grid">

                <div class="form-group full">
                    <label>Product Name *</label>
                    <input type="text" name="name"
                           placeholder="e.g. Nike Air Force 1" required>
                </div>

                <div class="form-group">
                    <label>Brand</label>
                    <input type="text" name="brand"
                           placeholder="e.g. Nike">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option value="">Select Category</option>
                        <option value="Sneakers">Sneakers</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Running">Running</option>
                        <option value="Casual">Casual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Size</label>
                    <input type="text" name="size"
                           placeholder="e.g. 9">
                </div>

                <div class="form-group">
                    <label>Color</label>
                    <input type="text" name="color"
                           placeholder="e.g. White">
                </div>

                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number" name="price"
                           min="0" step="0.01"
                           placeholder="0.00" required>
                </div>

                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number" name="quantity"
                           min="0" placeholder="0" required>
                </div>

                <div class="form-group full">
                    <label>Product Image</label>
                    <input type="file" name="image_file"
                           accept="image/png,image/jpeg,image/webp">
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description"
                              placeholder="Enter product description..."></textarea>
                </div>

            </div>

            <div class="buttons">
                <button type="submit" id="saveButton">
                    SAVE PRODUCT
                </button>

                <a href="/" class="cancel">CANCEL</a>
            </div>

            <p id="message"></p>

        </form>

    </div>
</div>

<script>
document.getElementById('productForm').addEventListener('submit',
async function(event) {

    event.preventDefault();

    const form = this;
    const button = document.getElementById('saveButton');
    const message = document.getElementById('message');

    button.disabled = true;
    button.textContent = 'SAVING...';
    message.textContent = '';

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: {
                'Accept': 'application/json'
            },
            credentials: 'same-origin'
        });

        const result = await response.json();

        if (!response.ok) {
            if (result.errors) {
                message.textContent =
                    Object.values(result.errors).flat().join(' ');
            } else {
                message.textContent =
                    result.message || 'Unable to save product.';
            }

            button.disabled = false;
            button.textContent = 'SAVE PRODUCT';
            return;
        }

        alert('Product added successfully!');
        window.location.href = '/';

    } catch (error) {
        message.textContent = 'Something went wrong. Please try again.';
        button.disabled = false;
        button.textContent = 'SAVE PRODUCT';
    }
});
</script>

</body>
</html>
