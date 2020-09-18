<?php

namespace Polygon;

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
     * @return false|string
     */
    public function getProductInfo(int $productId): string
    {
        $productData = $this->getProductInfoById($productId);

        return json_encode($productData);
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