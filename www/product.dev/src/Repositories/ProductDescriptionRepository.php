<?php declare(strict_types=1);

namespace Polygon\Repositories;

class ProductDescriptionRepository
{
    /**
     * @param int $productId
     * @return array
     */
    public function getProductDescriptionById(int $productId): array
    {
        $description = ($productId == 1)
            ? "It is a description about Lenovo advantages"
            : "It is about why MacBook Pro is so cool and expensive";

        return ['description' => $description];
    }
}