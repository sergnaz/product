<?php declare(strict_types=1);

namespace Polygon;

use PHPUnit\Framework\TestCase;
use Polygon\Repositories\ProductRepository;

class ProductServiceTest extends TestCase
{
    /**
     * @var ProductService
     */
    private $productService;

    protected function setUp(): void
    {
        $this->productService = new ProductService(new ProductRepository());
        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->productService);
        parent::tearDown();
    }

    public function testGetProductShortInfo()
    {
        $productInfo = $this->productService->getProductInfo(1);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'model' => 'ThinkPad E495',
                'type' => 'notebook',
                'manufacturer' => 'Lenovo',
            ]),
            $productInfo
        );
    }

    public function testGetSecondProductShortInfo()
    {
        $productInfo = $this->productService->getProductInfo(2);

        $this->assertJsonStringEqualsJsonString(
            json_encode([
                'model' => 'MacBook Pro',
                'type' => 'notebook',
                'manufacturer' => 'Apple',
            ]),
            $productInfo
        );
    }

    public function testNonExistProduct()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Product not exist");

        $this->productService->getProductInfo(404);
    }
}
