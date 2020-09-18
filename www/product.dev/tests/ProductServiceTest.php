<?php declare(strict_types=1);

namespace Polygon;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Polygon\Entities\Product;
use Polygon\Repositories\ProductDescriptionRepository;
use Polygon\Repositories\ProductInfoRepository;

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
     * @var MockObject|ProductInfoRepository
     */
    private $infoRepositoryMock;

    /**
     * @var MockObject|ProductDescriptionRepository
     */
    private $descriptionRepositoryMock;

    protected function setUp(): void
    {
        $this->infoRepositoryMock = $this->createMock(ProductInfoRepository::class);
        $this->descriptionRepositoryMock = $this->createMock(ProductDescriptionRepository::class);
        $this->productService = new ProductService(
            $this->infoRepositoryMock,
            $this->descriptionRepositoryMock
        );

        parent::setUp();
    }

    protected function tearDown(): void
    {
        unset(
            $this->productService,
            $this->infoRepositoryMock,
        );

        parent::tearDown();
    }

    /**
     * @return array
     */
    public function shortInfoDataProvider()
    {
        $productLenovo = new Product();
        $productLenovo->model = 'ThinkPad E495';
        $productLenovo->type = 'notebook';
        $productLenovo->manufacturer = 'Lenovo';
        $productLenovo->description = 'It is a description about Lenovo advantages';

        $productApple = new Product();
        $productApple->model = 'MacBook Pro';
        $productApple->type = 'notebook';
        $productApple->manufacturer = 'Apple';
        $productApple->description = 'It is about why MacBook Pro is so cool and expensive';

        return [
            [
                self::LENOVO_PRODUCT_ID,
                [
                    'model' => 'ThinkPad E495',
                    'type' => 'notebook',
                    'manufacturer' => 'Lenovo',
                ],
                [
                    'description' => 'It is a description about Lenovo advantages',
                ],
                $productLenovo,
            ],
            [
                self::APPLE_PRODUCT_ID,
                [
                    'model' => 'MacBook Pro',
                    'type' => 'notebook',
                    'manufacturer' => 'Apple',
                ],
                [
                    'description' => 'It is about why MacBook Pro is so cool and expensive'
                ],
                $productApple,
            ]
        ];
    }

    /**
     * @dataProvider shortInfoDataProvider
     * @param $productId
     * @param $productInfo
     * @param $productDescription
     * @param Product $expectedProduct
     */
    public function testGetProductShortInfo(
        $productId,
        $productInfo,
        $productDescription,
        Product $expectedProduct
    ){
        //Arrange
        $this->infoRepositoryWillReturn($productInfo);
        $this->descriptionRepositoryMock
            ->method('getProductDescriptionById')
            ->willReturn($productDescription);

        //Act
        $product = $this->productService->getProductInfo($productId);

        //Assert
        $this->assertEquals(
            $expectedProduct,
            $product
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

    private function infoRepositoryWillReturn($product): void
    {
        $this->infoRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willReturn($product);
    }

    private function productRepositoryWillThrowNotFountException(): void
    {
        $this->infoRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willThrowException(new \DomainException('Product not exist'));
    }
}
