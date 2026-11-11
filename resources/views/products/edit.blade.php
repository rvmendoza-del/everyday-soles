
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Product | Everyday Soles</title>

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

.current-image {
    max-width: 150px;
    max-height: 150px;
    object-fit: contain;
    margin-top: 10px;
    border-radius: 8px;
}

.errors {
    color: #ff6575;
    margin-bottom: 15px;
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
        <h1>✎ Edit Product</h1>
        <p>Update your Everyday Soles inventory information.</p>
    </div>

    <div class="form-card">

        @if ($errors->any())
            <div class="errors">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="form-grid">

                <div class="form-group full">
                    <label>Product Name *</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name', $product->name) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Brand</label>
                    <input type="text"
                           name="brand"
                           value="{{ old('brand', $product->brand) }}">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <select name="category">
                        <option value="">Select Category</option>

                        @foreach (['Sneakers', 'Basketball', 'Running', 'Casual'] as $category)
                            <option value="{{ $category }}"
                                {{ old('category', $product->category) == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="form-group">
                    <label>Size</label>
                    <input type="text"
                           name="size"
                           value="{{ old('size', $product->size) }}">
                </div>

                <div class="form-group">
                    <label>Color</label>
                    <input type="text"
                           name="color"
                           value="{{ old('color', $product->color) }}">
                </div>

                <div class="form-group">
                    <label>Price (₱) *</label>
                    <input type="number"
                           name="price"
                           min="0"
                           step="0.01"
                           value="{{ old('price', $product->price) }}"
                           required>
                </div>

                <div class="form-group">
                    <label>Quantity *</label>
                    <input type="number"
                           name="quantity"
                           min="0"
                           value="{{ old('quantity', $product->quantity) }}"
                           required>
                </div>

                <div class="form-group full">
                    <label>Current Product Image</label>

                    @if ($product->image)
                        <img
                            src="{{ $product->image }}"
                            class="current-image"
                            alt="Current Product Image">
                    @else
                        <p style="color:#aaa">No image uploaded.</p>
                    @endif
                </div>

                <div class="form-group full">
                    <label>Replace Product Image</label>
                    <input type="file"
                           name="image_file"
                           accept="image/png,image/jpeg,image/webp">
                    <small style="color:#aaa">
                        Leave empty to keep the current image.
                    </small>
                </div>

                <div class="form-group full">
                    <label>Description</label>
                    <textarea name="description">{{ old('description', $product->description) }}</textarea>
                </div>

            </div>

            <div class="buttons">

                <button type="submit">
                    UPDATE PRODUCT
                </button>

                <a href="{{ route('products.index') }}"
                   class="cancel">
                    CANCEL
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>
