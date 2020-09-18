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

    public function testGetProductShortInfo()
    {
        //Arrange
        $this->productRepositoryWillReturnLenovo();

        //Act
        $productInfo = $this->productService->getProductInfo(self::LENOVO_PRODUCT_ID);

        //Assert
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
        //Arrange
        $this->productRepositoryWillReturnApple();

        //Act
        $productInfo = $this->productService->getProductInfo(self::APPLE_PRODUCT_ID);

        //Assert
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
        //Arrange
        $this->productRepositoryWillThrowNotFountException();

        //Act
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Product not exist");

        //Assert
        $this->productService->getProductInfo(self::NOT_FOUND_PRODUCT_ID);
    }

    private function productRepositoryWillReturnLenovo(): void
    {
        $this->productRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willReturn([
                'model' => 'ThinkPad E495',
                'type' => 'notebook',
                'manufacturer' => 'Lenovo',
            ]);
    }

    private function productRepositoryWillReturnApple(): void
    {
        $this->productRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willReturn([
                'model' => 'MacBook Pro',
                'type' => 'notebook',
                'manufacturer' => 'Apple',
            ]);
    }

    private function productRepositoryWillThrowNotFountException(): void
    {
        $this->productRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willThrowException(new \DomainException('Product not exist'));
    }
}
