<?php

use Polygon\ProductService;
use Polygon\Repositories\ProductDescriptionRepository;
use Polygon\Repositories\ProductImagesRepository;
use Polygon\Repositories\ProductInfoRepository;

include 'vendor/autoload.php';

    $product = new ProductService(
        new ProductInfoRepository(),
        new ProductDescriptionRepository(),
        new ProductImagesRepository()
    );

    header('Content-Type: application/json');
    $product = $product->getProductInfo(1);

    echo json_encode($product);
