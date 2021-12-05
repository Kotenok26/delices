<?php

namespace App\Controller;

use App\Classe\Mail;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/nous-contacter", name="contact")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('notice', 'Merci de nous avoir contacté. Notre équiupe va vous repondre dans les meilleurs délais.');
            $formData = $form->getData();
            if ($formData['content']== null){

                $content  = "Nom : ".$formData['prenom']." ".$formData['nom']."<br>";
                $content .= "Email : ".$formData['email']."<br>";
                $content .= "Message : <br>".$formData['content2'];

                $mail = new Mail();
                $mail->send('lacaveauxdelices45@gmail.com', 'La Cave aux Délices', 'Vous avez reçu une nouvelle demande de contact', $content);
            }
        }


        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}