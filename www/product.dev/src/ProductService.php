<?php

namespace Polygon;

use Polygon\Repositories\ProductRepository;

class ProductService
{
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
     * @return array
     */
    private function getProductInfoById(int $productId): array
    {
        $productRepo = new ProductRepository();

        return $productRepo->getProductInfoById($productId);
    }
}