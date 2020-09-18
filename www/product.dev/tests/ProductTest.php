<?php declare(strict_types=1);

namespace Polygon;

use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testGetProductShortInfo()
    {
        $product = new Product();
        $productData = $product->getProductInfo(1);

        $this->assertEquals(['model' => 'ThinkPad E495'], $productData);
    }
}
