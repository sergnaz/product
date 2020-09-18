<?php
    include 'vendor/autoload.php';

    $product = new \Polygon\ProductService();

    header('Content-Type: application/json');
    echo $product->getProductInfo(2);
