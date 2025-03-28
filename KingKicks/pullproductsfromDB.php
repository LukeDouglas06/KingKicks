<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title> Untitled Document </title>
</head>
<body>
    <?php
    include "DBconfig.php";
    include "product.php";

    //Build Query
    $sql = "SELECT * FROM products";
    $QRYresult = mysqli_query($conn, $sql);

    // NOW USE PRODUCT CLASS TO OUTPUT
    $product = new product(); //MAKE A PRODUCT OBJECT TO TAKE PRODUCT DATA

    if (mysqli_num_rows($QRYresult) > 0) {
        while($row = mysqli_fetch_array($QRYresult)) {
            $product->setproductID($row['PRODUCT_ID']);
            $product->setproductName($row['PRODUCT_NAME']);
            $product->setBrand($row['BRAND']);
            $product->setPrice($row['PRICE']);
            $product->setamountordered($row['AMOUNTORDERED']);
            $product->setStock($row['STOCK']);
            $product->setimage($row['IMAGE']);
            $product->display();
        }
    }
    else {
        echo "0 results";
    }
    ?>