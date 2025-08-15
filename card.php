<?php
$con = mysqli_connect("localhost", "root", "", "crud");

if (isset($_POST['btn'])) {
    $file = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp_name, "photos/$file");

    $title = $_POST['title'];
    $price = $_POST['price'];
    $des = $_POST['des'];
    $stock = $_POST['stock'];

    $sql = "INSERT INTO `card`(`image`, `title`, `price`, `des`, `stock`) 
            VALUES ('$file','$title','$price','$des','$stock')";

    mysqli_query($con, $sql);

    header("Location: fetch.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Upload</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #4b2e2b, #000000);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
        }

        form {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            padding: 25px;
            border-radius: 20px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4),
                        inset 0 1px 1px rgba(255, 255, 255, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.2);
            animation: fadeIn 0.7s ease-in-out;
        }

        form label {
            font-weight: bold;
            color: white;
            display: block;
            margin-bottom: 5px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            font-size: 14px;
        }

        form input[type="text"],
        form input[type="file"] {
            width: 100%;
            padding: 8px 10px;
            border: none;
            border-radius: 8px;
            outline: none;
            background: rgba(255, 255, 255, 0.9);
            box-shadow: inset 2px 2px 5px rgba(0, 0, 0, 0.15),
                        inset -2px -2px 5px rgba(255, 255, 255, 0.6);
            margin-bottom: 15px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        form input[type="text"]:focus,
        form input[type="file"]:focus {
            box-shadow: 0 0 6px #8b4513,
                        inset 2px 2px 5px rgba(0, 0, 0, 0.15),
                        inset -2px -2px 5px rgba(255, 255, 255, 0.6);
            transform: translateY(-2px);
        }

        .radio-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        .radio-group label {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background: linear-gradient(145deg, #8b4513, #5a2d0c);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.3),
                        -4px -4px 8px rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }
        button:hover {
            transform: translateY(-3px);
            box-shadow: 6px 6px 12px rgba(0, 0, 0, 0.4),
                        -6px -6px 12px rgba(255, 255, 255, 0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @media (max-width: 480px) {
            form { padding: 20px; max-width: 90%; }
            button { font-size: 14px; padding: 9px; }
        }
    </style>
</head>
<body>
    <form id="productForm" action="" method="post" enctype="multipart/form-data">
        <label>Upload Product</label>
        <input id="imageInput" name="image" type="file" accept="image/*" required>
        <div style="margin-bottom: 15px;">
            <img id="preview" src="" alt="" style="max-width:100%; display:none; border-radius:8px;"/>
        </div>

        <label>Enter Title</label>
        <input name="title" placeholder="Enter Title" type="text" required>

        <label>Enter Price</label>
        <input id="price" name="price" placeholder="Enter Price" type="text" required>
        
        <label>Enter Description</label>
        <input name="des" placeholder="Enter Description" type="text" required>

        <label>Stock Available</label>
        <div class="radio-group">
            <label><input type="radio" value="1" name="stock" required> Stock Available</label>
            <label><input type="radio" value="0" name="stock" required> Stock Not Available</label>
        </div>

        <button name="btn" type="submit">Upload</button>
    </form>

    <script>
        const form = document.getElementById('productForm');
        const imageInput = document.getElementById('imageInput');
        const preview = document.getElementById('preview');
        const priceInput = document.getElementById('price');

        // Live Image Preview
        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                if (!file.type.startsWith('image/')) {
                    alert('Please upload a valid image file.');
                    this.value = '';
                    preview.style.display = 'none';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });

        // Form Validation
        form.addEventListener('submit', function (e) {
            const priceValue = priceInput.value.trim();
            if (isNaN(priceValue) || Number(priceValue) <= 0) {
                e.preventDefault();
                alert('Please enter a valid positive price.');
                return;
            }

            const file = imageInput.files[0];
            if (!file || !file.type.startsWith('image/')) {
                e.preventDefault();
                alert('Please upload a valid image.');
            }
        });
    </script>
</body>
</html>
