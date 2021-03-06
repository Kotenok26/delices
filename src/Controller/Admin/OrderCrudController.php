<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Doctrine\ORM\EntityManagerInterface;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;
    private $AdminUrlGenerator;

    public function __construct(EntityManagerInterface $entityManager, AdminUrlGenerator $AdminUrlGenerator)
    {
        $this->entityManager = $entityManager;
        $this->AdminUrlGenerator = $AdminUrlGenerator;
    }


    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('updateDelivery');

        return $actions
            ->add('detail', $updatePreparation)
            ->add('detail', $updateDelivery)
            ->add('index', 'detail');
    }

    public function updatePreparation(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:green;'><strong>La commande ".$order->getReference()." est bien <u>en cours de préparation</u>.</strong></span>");

        $url = $this->AdminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();



        // Envoyer un email à notre client pour lui confirmer la préparation
        $mail = new Mail();
        $content = "Bonjour ".$order->getUser()->getFirstname().",<br/>Votre commande est en cours de preparation<br><br/>Vous pouvez accéder à tout moment au suivi de votre commande dans votre espace personnel sur La Cave aux Délices! Alias amet asperiores, commodi, consectetur, dolor enim eos est eum itaque laboriosam libero magnam magni nostrum numquam odit officiis provident quia repellendus suscipit veniam! Accusantium, adipisci asperiores aspernatur at, cum minima minus nesciunt perferendis, rem tempora veritatis.";
        $mail->send($order->getUser()->getEmail(),$order->getUser()->getFirstname(), 'Votre commande sur La cave aux délices', $content);

        return $this->redirect($url);
    }

    public function updateDelivery(AdminContext $context)
    {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span style='color:orange;'><strong>La commande ".$order->getReference()." est bien <u>en cours de livraison</u>.</strong></span>");

        $url = $this->AdminUrlGenerator
            ->setController(OrderCrudController::class)
            ->setAction('index')
            ->generateUrl();

        // Envoyer un email à notre client pour lui confirmer sa commande
        $mail = new Mail();
        $content = "Bonjour ".$order->getUser()->getFirstname().",<br/>Votre commande a été livrée<br><br/>Vous pouvez accéder à tout moment au suivi de votre commande dans votre espace personnel sur La Cave aux Délices! Facere laudantium neque odit ratione! Alias amet asperiores, commodi, consectetur, dolor enim eos est eum itaque laboriosam libero magnam magni nostrum numquam odit officiis provident quia repellendus suscipit veniam! Accusantium, adipisci asperiores aspernatur at, cum minima minus nesciunt perferendis, rem tempora veritatis.";
        $mail->send($order->getUser()->getEmail(),$order->getUser()->getFirstname(), 'Votre commande sur La cave aux délices', $content);

        return $this->redirect($url);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passée le'),
            TextField::new('user.fullname', 'Utilisateur'),
            TextEditorField::new('delivery', 'Adresse de livraison')->onlyOnDetail(),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            TextField::new('carrierName', 'Transporteur'),
            MoneyField::new('carrierPrice', 'Frais de port')->setCurrency('EUR'),
            ChoiceField::new('state')->setChoices([
                'Non payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'Livraison en cours' => 3
            ]),
            ArrayField::new('orderDetails', 'Produits achetés')->hideOnIndex()
        ];
    }

}
