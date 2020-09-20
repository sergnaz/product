<?php declare(strict_types=1);

namespace Polygon;

use Polygon\Entities\Product;
use Polygon\Repositories\ProductDescriptionRepository;
use Polygon\Repositories\ProductImagesRepository;
use Polygon\Repositories\ProductInfoRepository;

class ProductService
{
    /**
     * @var ProductInfoRepository
     */
    private $infoRepository;

    /**
     * @var ProductDescriptionRepository
     */
    private $descriptionRepository;

    /**
     * @var ProductImagesRepository
     */
    private $productImagesRepository;

    public function __construct(
        ProductInfoRepository $infoRepository,
        ProductDescriptionRepository $descriptionRepository,
        ProductImagesRepository $productImagesRepository
    ){
        $this->infoRepository = $infoRepository;
        $this->descriptionRepository  = $descriptionRepository;
        $this->productImagesRepository = $productImagesRepository;
    }

    /**
     * @param int $productId
     * @throws \DomainException
     * @return Product
     */
    public function getProductInfo(int $productId): Product
    {
        $productData = $this->infoRepository->getProductInfoById($productId);
        $productDescription = $this->descriptionRepository->getProductDescriptionById($productId);
        $productPhotos = $this->productImagesRepository->getImagesByProductId($productId);

        $product = new Product();
        $product->model = $productData['model'];
        $product->type = $productData['type'];
        $product->manufacturer = $productData['manufacturer'];
        $product->description = $productDescription['description'];
        $product->photos = $productPhotos;

        return $product;
    }
}