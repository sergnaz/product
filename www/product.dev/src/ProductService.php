<?php

namespace Polygon;

use Polygon\Entities\Product;
use Polygon\Repositories\ProductRepository;

class ProductService
{
    private $productRepo;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepo = $productRepository;
    }

    /**
     * @param int $productId
     * @throws \DomainException
     * @return Product
     */
    public function getProductInfo(int $productId): Product
    {
        $productData = $this->getProductInfoById($productId);

        $product = new Product();
        $product->model = $productData['model'];
        $product->type = $productData['type'];
        $product->manufacturer = $productData['manufacturer'];

        return $product;
    }

    /**
     * @param int $productId
     * @throws \DomainException
     * @return array
     */
    private function getProductInfoById(int $productId): array
    {
        return $this->productRepo->getProductInfoById($productId);
    }
}