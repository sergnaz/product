<?php declare(strict_types=1);

namespace Polygon\Repositories;


class ProductImagesRepository
{
    public function getImagesByProductId(int $productId)
    {
        return ($productId == 1)
            ? ['Large.jpg', 'Thumb.jpg']
            : ['Steve Jobs recommends.jpg', 'MacBookPro.jpg', 'Monitor.jpg'];
    }
}