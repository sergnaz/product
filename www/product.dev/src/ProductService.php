<?php declare(strict_types=1);

namespace Polygon;

use Polygon\Entities\Product;
use Polygon\Repositories\ProductDescriptionRepository;
use Polygon\Repositories\ProductImagesRepository;
use Polygon\Repositories\ProductInfoRepository;
use Polygon\Repositories\ProductVideosRepository;

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

    /**
     * @var ProductVideosRepository
     */
    private $productVideosRepository;

    public function __construct(
        ProductInfoRepository $infoRepository,
        ProductDescriptionRepository $descriptionRepository,
        ProductImagesRepository $productImagesRepository,
        ProductVideosRepository $productVideosRepository
    ){
        $this->infoRepository = $infoRepository;
        $this->descriptionRepository  = $descriptionRepository;
        $this->productImagesRepository = $productImagesRepository;
        $this->productVideosRepository = $productVideosRepository;
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
        $productVideos = $this->productVideosRepository->getVideosByProductId($productId);

        $product = new Product();
        $product->model = $productData['model'];
        $product->type = $productData['type'];
        $product->manufacturer = $productData['manufacturer'];
        $product->description = $productDescription['description'];
        $product->photos = $productPhotos;
        $product->videos = $productVideos;

        return $product;
    }
}