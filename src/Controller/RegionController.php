<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Region;
use App\Form\SearchType;
use App\Repository\BrandRepository;
use App\Repository\RegionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class RegionController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/régions", name="regions")
     */
    public function index()
    {
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $regions = $this->entityManager->getRepository(Region::class)->findAll();
        $brands = $this->entityManager->getRepository(Brand::class)->findAll();

//        dd($brands);

        return $this->render('region/index.html.twig', [
            'products' => $products,
            'regions' => $regions,
            'brands' => $brands,
        ]);
    }
    /**
     * @Route("/régions/{slug}", name="region")
     */

    public function show($slug, PaginatorInterface $paginator, Request $request)
    {
        $region = $this->entityManager->getRepository(Region::class)->findOneBySlug($slug);
        $brands = $this->entityManager->getRepository(Brand::class)->findByRegion($region);
        $products = $paginator->paginate(
            $this->entityManager->getRepository(Product::class)->findByBrand($brands),
            $request->query->getInt('page', 1),
            12
        );
//        if(!$brand) {
//            return $this->redirectToRoute('regions');
//        }

        return $this->render('region/region.html.twig', [
            'region' => $region,
            'brands' => $brands,
            'products' => $products
        ]);
    }
    /**
     * @Route("/brand/{id}", name="productByBrand")
     */

    public function showProducts(?Brand $brand):Response
    {
        if($brand){
            $products = $this->entityManager->getRepository(Product::class)->findByBrand($brand);

        }else{
            return $this->redirectToRoute('region');
        }
//        dd($brand);

        return $this->render('region/product_by_brand.html.twig',[
            'products' => $products,
            'brand' => $brand,
        ]);
    }
}
