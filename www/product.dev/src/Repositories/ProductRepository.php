<?php

namespace Polygon\Repositories;

class ProductRepository
{
    /**
     * @param int $productId
     * @throws \DomainException
     * @return array
     */
    public function getProductInfoById(int $productId): array
    {
        //TODO: Hardcoded, we should use some kind of real storage ... but it will be later
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