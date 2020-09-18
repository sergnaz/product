<?php

namespace Polygon;

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
        if ($productId == 1) {
            $productData = [
                'model' => 'ThinkPad E495',
                'type' => 'notebook',
                'manufacturer' => 'Lenovo',
            ];
        } elseif ($productId == 2) {
            $productData = [
                'model' => 'MacBook Pro',
                'type' => 'notebook',
                'manufacturer' => 'Apple',
            ];
        } else {
            throw new \DomainException("Product not exist");
        }
        return $productData;
    }
}