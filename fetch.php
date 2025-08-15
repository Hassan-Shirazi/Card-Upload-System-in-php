<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Product Cards</title>
<link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Our Products</h1>

<div class="grid">
<?php
$con = mysqli_connect("localhost","root","","crud");

$sql = "SELECT * FROM `card`";
$data = mysqli_query($con , $sql);

while($fetch = mysqli_fetch_assoc($data)){
    $file = $fetch['image'];
    $title = $fetch['title'];
    $price = $fetch['price'];
    $des = $fetch['des'];
    $stock = $fetch['stock'];

    $stock_avalaible = $stock == 0 ? "<i style='text-decoration: line-through;'>Stock Not Available</i>" : "Stock Available";

    echo "
    <div class='card'>
        <img src='photos/$file'>
        <h2>$title</h2>
        <p class='price'>$$price</p>
        <p class='description'>$des</p>
        <p class='stock'>$stock_avalaible</p>
    </div>
    ";
}
?>
</div>

<script src = "script.js"></script>

</body>
</html>
