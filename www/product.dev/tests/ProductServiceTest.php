<?php declare(strict_types=1);

namespace Polygon;

use DomainException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Polygon\Entities\Product;
use Polygon\Repositories\ProductDescriptionRepository;
use Polygon\Repositories\ProductImagesRepository;
use Polygon\Repositories\ProductInfoRepository;
use Polygon\Repositories\ProductVideosRepository;

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

    /**
     * @var MockObject|ProductImagesRepository
     */
    private $productImagesRepositoryMock;

    /**
     * @var MockObject|ProductVideosRepository
     */
    private $productVideosRepositoryMock;

    protected function setUp(): void
    {
        $this->infoRepositoryMock = $this->createMock(ProductInfoRepository::class);
        $this->descriptionRepositoryMock = $this->createMock(ProductDescriptionRepository::class);
        $this->productImagesRepositoryMock = $this->createMock(ProductImagesRepository::class);
        $this->productVideosRepositoryMock = $this->createMock(ProductVideosRepository::class);

        $this->productService = new ProductService(
            $this->infoRepositoryMock,
            $this->descriptionRepositoryMock,
            $this->productImagesRepositoryMock,
            $this->productVideosRepositoryMock
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
        $productLenovo->photos = [
            'Large.jpg',
            'Thumb.jpg',
        ];
        $productLenovo->videos = [
            'review about ThinkPad.avi'
        ];

        $productApple = new Product();
        $productApple->model = 'MacBook Pro';
        $productApple->type = 'notebook';
        $productApple->manufacturer = 'Apple';
        $productApple->description = 'It is about why MacBook Pro is so cool and expensive';
        $productApple->photos = [
            'Steve Jobs recommends.jpg',
            'MacBookPro.jpg',
            'Monitor.jpg',
        ];
        $productApple->videos = [
            'About MacBookPro.avi',
            'Review by Max.avi'
        ];

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
                [
                    'Large.jpg',
                    'Thumb.jpg',
                ],
                [
                    'review about ThinkPad.avi',
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
                    'description' => 'It is about why MacBook Pro is so cool and expensive',
                ],
                [
                    'Steve Jobs recommends.jpg',
                    'MacBookPro.jpg',
                    'Monitor.jpg',
                ],
                [
                    'About MacBookPro.avi',
                    'Review by Max.avi'
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
     * @param $photos
     * @param $videos
     * @param Product $expectedProduct
     */
    public function testGetProductShortInfo(
        $productId,
        $productInfo,
        $productDescription,
        $photos,
        $videos,
        Product $expectedProduct
    ){
        //Arrange
        $this->infoRepositoryWillReturn($productInfo, $productId);
        $this->descriptionRepositoryMock
            ->method('getProductDescriptionById')
            ->with($productId)
            ->willReturn($productDescription);
        $this->productImagesRepositoryMock
            ->method('getImagesByProductId')
            ->with($productId)
            ->willReturn($photos);
        $this->productVideosRepositoryMock
            ->method('getVideosByProductId')
            ->with($productId)
            ->willReturn($videos);

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
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage("Product not exist");

        //Assert
        $this->productService->getProductInfo(self::NOT_FOUND_PRODUCT_ID);
    }

    private function infoRepositoryWillReturn($product, $productId): void
    {
        $this->infoRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->with($productId)
            ->willReturn($product);
    }

    private function productRepositoryWillThrowNotFountException(): void
    {
        $this->infoRepositoryMock
            ->method(self::getProductInfoByIdMethod)
            ->willThrowException(new DomainException('Product not exist'));
    }
}
