<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Classe\StockManager;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, StockManager $stockManager)
    {
        $this->entityManager = $entityManager;
        $this->StockManager = $stockManager;
    }

    /**
     * @Route("/commande/merci/{stripeSessionId}", name="order_validate")
     */
    public function index(Cart $cart, StockManager $stockManager, $stripeSessionId)
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripeSessionId($stripeSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0) {
            //Vider la session "cart"
            $cart->remove();

            // Modifier le statut de notre commande en mettant 1
            $order->setState(1);
            // Destockage
            $stockManager->deStock($order);
            $this->entityManager->flush();

            // Envoyer un email à notre client pour lui confirmer sa commande
            $mail = new Mail();
            $content = "Bonjour ".$order->getUser()->getFirstname().",<br/>Merci pour votre commande<br><br/>Votre commande sur La cave aux Délices est bien validée. Facere laudantium neque odit ratione! Alias amet asperiores, commodi, consectetur, dolor enim eos est eum itaque laboriosam libero magnam magni nostrum numquam odit officiis provident quia repellendus suscipit veniam! Accusantium, adipisci asperiores aspernatur at, cum minima minus nesciunt perferendis, rem tempora veritatis.";
            $mail->send($order->getUser()->getEmail(),$order->getUser()->getFirstname(), 'Votre commande sur La cave aux Délices est bien validée', $content);

        }
        // Afficher les infos de la commande de l'utilisateur

        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}
