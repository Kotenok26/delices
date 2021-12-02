<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Subcategory;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/categories", name="categories")
     */
    public function index()
    {
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);
        $categories = $this->entityManager->getRepository(Category::class)->findAll();


        return $this->render('category/index.html.twig', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/catégories/{slug}", name="subcategory")
     */

    public function show($slug)
    {
        $subcategory = $this->entityManager->getRepository(Subcategory::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Product::class)->findBySubcategory($subcategory);


        if(!$subcategory) {
            return $this->redirectToRoute('categories');
        }

        return $this->render('category/subcategory.html.twig', [
            'subcategory' => $subcategory,
            'products' => $products
        ]);
    }
    /**
     * @Route("/souscatégories/{id}", name="subcategoryByCategory")
     */

    public function getSubcategories(?Category $category):Response
    {
        if($category){
        $subcategories = $category->getSubcategories()->getValues();
        }else{
            return $this->redirectToRoute('categories');
        }
        $categories = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('category/subcat_by_cat.html.twig',[
            'subcategories' => $subcategories,
            'categories' => $categories,
        ]);
    }
}
