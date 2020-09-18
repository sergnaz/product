<?php declare(strict_types=1);

namespace Polygon;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Polygon\Repositories\ProductRepository;

class ProductServiceTest extends TestCase
{
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var MockObject|ProductRepository
     */
    private $productRepositoryMock;

    protected function setUp(): void
    {
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->productService = new ProductService($this->productRepositoryMock);

        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset($this->productService);
        parent::tearDown();
    }

    public function testGetProductShortInfo()
    {
        $this->productRepositoryMock
            ->method('getProductInfoById')
            ->willReturn([
                'model' => 'ThinkPad E495',
                'type' => 'notebook',
                'manufacturer' => 'Lenovo',
            ]);

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
        $this->productRepositoryMock
            ->method('getProductInfoById')
            ->willReturn([
                'model' => 'MacBook Pro',
                'type' => 'notebook',
                'manufacturer' => 'Apple',
            ]);

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
        $this->productRepositoryMock
            ->method('getProductInfoById')
            ->willThrowException(new \DomainException('Product not exist'));
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Product not exist");

        $this->productService->getProductInfo(404);
    }
}
