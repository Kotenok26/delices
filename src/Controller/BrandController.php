<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/fournisseur", name="brand")
     */
    public function index()
    {
        $brands = $this->entityManager->getRepository(Brand::class)->findAll();
        $products = $this->entityManager->getRepository(Product::class)->findAll();

        return $this->render('brand/index.html.twig', [
            'brands' => $brands,
            'products' => $products
        ]);
    }
}
