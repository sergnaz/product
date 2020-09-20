<?php

namespace Polygon\Repositories;

class ProductVideosRepository
{
    /**
     * @param int $productId
     * @return array
     */
    public function getVideosByProductId(int $productId): array
    {
        return ($productId == 1)
            ? ['review about ThinkPad.avi']
            : ['About MacBookPro.avi', 'Review by Max.avi'];
    }
}