<?php

namespace App\Twig;

use App\Repository\RegionRepository;
use App\Repository\SubcategoryRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class  AppExtension extends AbstractExtension
{
    private $subcategoryRepository;
    private $regionRepository;

    public function  __construct(SubcategoryRepository $subcategoryRepository, RegionRepository $regionRepository)
    {
        $this->subcategoryRepository = $subcategoryRepository;
        $this->regionRepository = $regionRepository;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('subcategoryNavbar', [$this, 'subcategory'], ),
            new TwigFunction('regionNavbar', [$this, 'region'], ),
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

}
