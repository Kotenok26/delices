<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Product;
use App\Entity\Brand;
use App\Entity\Subcategory;

class ProductUnitTest extends TestCase
{
    public function testIsTrue()
    {
        $product = new Product();
        $brand = new Brand();
        $subcategory = new Subcategory();

        $product->setName('product')
                ->setSlug('slug')
                ->setSubcategory($subcategory)
                ->setBrand($brand)
                ->setIllustration('illustration')
                ->setDescription('description')
                ->setPrice(20.20)
                ->setIsBest(true)
                ->setWeight(250)
                ->setPricepkilo(250)
                ->setQuantity(20);

        $this->assertTrue($product->getName() === 'product');
        $this->assertTrue($product->getSlug() === 'slug');
        $this->assertContains($subcategory, $product->getSubcategory());
        $this->assertContains($brand, $product->getBrand());
        $this->assertTrue($product->getIllustration() === 'illustration');
        $this->assertTrue($product->getDescription() === 'description');
        $this->assertTrue($product->getPrice() === 20.20);
        $this->assertTrue($product->getIsBest() === true);
        $this->assertTrue($product->getWeight() === 250);
        $this->assertTrue($product->getPricepkilo() === 250);
        $this->assertTrue($product->getQuantity() === 25);

    }

    public function testIsFalse()
    {
        $product = new Product();
        $brand = new Brand();
        $subcategory = new Subcategory();

        $product->setName('product')
            ->setSlug('slug')
            ->setSubcategory($subcategory)
            ->addBrand($brand)
            ->setIllustration('illustration')
            ->setDescription('description')
            ->setPrice(20.20)
            ->setIsBest(true)
            ->setWeight(250)
            ->setPricepkilo(250)
            ->setQuantity(20);


        $this->assertFalse($product->getName() === 'false');
        $this->assertFalse($product->getSlug() === 'false');
        $this->assertNotContains(new Subcategory(), $product->getSubcategory());
        $this->assertNotContains(new Brand(), $product->getBrand());
        $this->assertFalse($product->getIllustration() === 'false');
        $this->assertFalse($product->getDescription() === 'false');
        $this->assertFalse($product->getPrice() === 21.20);
        $this->assertFalse($product->getIsBest() === false);
        $this->assertFalse($product->getWeight() === 350);
        $this->assertFalse($product->getPricepkilo() === 350);
        $this->assertFalse($product->getQuantity() === 45);
    }

    public function testIsEmpty()
    {
        $product = new Product();

        $this->assertEmpty($product->getName());
        $this->assertEmpty($product->getSlug());
        $this->assertEmpty($product->getSubcategory());
        $this->assertEmpty($product->getBrand());
        $this->assertEmpty($product->getIllustration());
        $this->assertEmpty($product->getDescription());
        $this->assertEmpty($product->getPrice());
        $this->assertEmpty($product->getIsBest());
        $this->assertEmpty($product->getWeight());
        $this->assertEmpty($product->getPricepkilo());
        $this->assertEmpty($product->getQuantity());

    }

}
