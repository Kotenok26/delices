<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/conseils", name="articles")
     */

    public function index()
    {
        $articles = $this->entityManager->getRepository(Article::class)->findAll();

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/conseils/{slug}", name="article")
     */

    public function show($slug)
    {
        $article = $this->entityManager->getRepository(Article::class)->findOneBySlug($slug);


        if(!$article) {
            return $this->redirectToRoute('articles');
        }

        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }
}
