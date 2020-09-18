<?php declare(strict_types=1);

namespace Polygon;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Polygon\Repositories\ProductRepository;

class ProductServiceTest extends TestCase
{
    const getProductInfoByIdMethod = 'getProductInfoById';
    const NOT_FOUND_PRODUCT_ID = 404;
    const LENOVO_PRODUCT_ID = 1;
    const APPLE_PRODUCT_ID = 2;

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
        unset(
            $this->productService,
            $this->productRepositoryMock,
        );

        parent::tearDown();
    }

    /**
     * @return array
     */
    public function shortInfoDataProvider()
    {
        return [
            [
                self::LENOVO_PRODUCT_ID,
                [
                    'model' => 'ThinkPad E495',
                    'type' => 'notebook',
                    'manufacturer' => 'Lenovo',
                ],
                json_encode([
                    'model' => 'ThinkPad E495',
                    'type' => 'notebook',
                    'manufacturer' => 'Lenovo',
                ]),
            ],
            [
                self::APPLE_PRODUCT_ID,
                [
                    'model' => 'MacBook Pro',
                    'type' => 'notebook',
                    'manufacturer' => 'Apple',
                ],
                json_encode([
                    'model' => 'MacBook Pro',
                    'type' => 'notebook',
                    'manufacturer' => 'Apple',
                ]),
            ]
        ];
    }

    /**
     * @dataProvider shortInfoDataProvider
     * @param $productId
     * @param $product
     * @param $expectedProduct
     */
    public function testGetProductShortInfo($productId, $product, $expectedProduct)
    {
        //Arrange
        $this->productRepositoryWillReturn($product);

        //Act
        $productInfo = $this->productService->getProductInfo($productId);

        //Assert
        $this->assertJsonStringEqualsJsonString(
            $expectedProduct,
            $productInfo
        );
    }

    public function testNonExistProduct()
    {
        //Arrange
        $this->productRepositoryWillThrowNotFountException();

        //Act
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Product not exist");

        //Assert
        $this->productService->getProductInfo(self::NOT_FOUND_PRODUCT_ID);
    }

    private function productRepositoryWillReturn($product): void
    {
        $this->productRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willReturn($product);
    }

    private function productRepositoryWillThrowNotFountException(): void
    {
        $this->productRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willThrowException(new \DomainException('Product not exist'));
    }
}
