<?php

namespace App\Classe;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Region;
use App\Entity\Subcategory;

class Search
{
    /**
     * @var string
     */
    public $string = '';

    /**
     * @var Category[]
     */
    public $categories = [];

    /**
     * @var Subcategory[]
     */
    public $subcategories = [];

    /**
     * @var Region[]
     */
    public $regions = [];

    /**
     * @var Brand[]
     */
    public $brands = [];
}
