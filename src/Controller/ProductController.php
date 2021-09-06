<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/nos-produits", name="products")
     */

    public function index(PaginatorInterface $paginator, Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $products = $paginator->paginate(
                $this->entityManager->getRepository(Product::class)->findWithSearch($search),
                $request->query->getInt('page', 1),
                12
            );
        } else {
            $products = $paginator->paginate(
                $this->entityManager->getRepository(Product::class)->findAll(),
                $request->query->getInt('page', 1),
                12
            );
        }

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
//            'pagination' => $pagination
        ]);
    }

//    public function listAction(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
//    {
//        $dql   = "SELECT a FROM AcmeMainBundle:Article a";
//        $query = $em->createQuery($dql);
//
//        $pagination = $paginator->paginate(
//            $query, /* query NOT result */
//            $request->query->getInt('page', 1), /*page number*/
//            10 /*limit per page*/
//        );
//
//        // parameters to template
//        return $this->render('article/list.html.twig', ['pagination' => $pagination]);
//    }



    /**
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug)
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        $products = $this->entityManager->getRepository(Product::class)->findByIsBest(1);

        if(!$product) {
            return $this->redirectToRoute('products');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
            'products' => $products
        ]);
    }

}

