<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Utils\Serializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/api/products/{id}", name="api_product")
     */
    public function show(Product $product, Serializer $serializer): JsonResponse
    {
        $jsonProducts = $serializer->serialize($product, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);

        return $this->json([
            'data' => $jsonProducts,
        ], Response::HTTP_OK);
    }
}
