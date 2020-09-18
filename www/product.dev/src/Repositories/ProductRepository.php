<?php

namespace Polygon\Repositories;

class ProductRepository
{
    /**
     * @param int $productId
     * @return array
     */
    public function getProductInfoById(int $productId): array
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