<?php

namespace App\Twig;

use App\Repository\RegionRepository;
use App\Repository\SubcategoryRepository;
use App\Classe\Cart;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class  AppExtension extends AbstractExtension
{
    private $subcategoryRepository;
    private $regionRepository;
    private $cart;

    public function  __construct(SubcategoryRepository $subcategoryRepository, RegionRepository $regionRepository, cart $cart)
    {
        $this->subcategoryRepository = $subcategoryRepository;
        $this->regionRepository = $regionRepository;
        $this->cart = $cart;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('subcategoryNavbar', [$this, 'subcategory'], ),
            new TwigFunction('regionNavbar', [$this, 'region'], ),
            new TwigFunction('cartLength', [$this, 'cart'], ),
        ];

    }
    public function subcategory(): array
    {
        return $this->subcategoryRepository->findAll();
    }
    public function region(): array
    {
        return $this->regionRepository->findAll();
    }
    public function cart()
    {
        return $this->cart->get();
    }

}
