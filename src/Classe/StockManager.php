<?php

namespace App\Classe;

use App\Entity\Product;
use App\Entity\Order;
use App\Entity\OrderDetails;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class StockManager
{
    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
    }

    public function deStock(Order $order)
    {
        $orderDetails = $order->getOrderDetails()->getValues();

        foreach ($orderDetails as $key => $details){
            $product = $this->entityManager->getRepository(Product::class)->findOneByName($details->getProduct());
            $newQuantity = $product->getQuantity() - $details->getQuantity();
            $product->setQuantity($newQuantity);
            $this->entityManager->flush();
        }

    }




}