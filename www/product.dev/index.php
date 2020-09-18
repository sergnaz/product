<?php
    include 'vendor/autoload.php';

    $product = new \Polygon\Product();

    header('Content-Type: application/json');
    echo json_encode($product->getProductInfo());

