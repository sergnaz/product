<?php

namespace Polygon;

use Polygon\Entities\Product;
use Polygon\Repositories\ProductDescriptionRepository;
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

    public function __construct(
        ProductInfoRepository $infoRepository,
        ProductDescriptionRepository $descriptionRepository
    ){
        $this->infoRepository = $infoRepository;
        $this->descriptionRepository  = $descriptionRepository;
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

        $product = new Product();
        $product->model = $productData['model'];
        $product->type = $productData['type'];
        $product->manufacturer = $productData['manufacturer'];
        $product->description = $productDescription['description'];

        return $product;
    }
}