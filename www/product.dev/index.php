<?php

use Polygon\ProductService;
use Polygon\Repositories\ProductRepository;

include 'vendor/autoload.php';

    $product = new ProductService(new ProductRepository());

    header('Content-Type: application/json');
    echo $product->getProductInfo(1);
