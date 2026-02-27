<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function index(Request $request): Response
    {
        // Création du formulaire
        $form = $this->createForm(ContactType::class);

        // Récupère les données envoyées (POST)
        $form->handleRequest($request);

        // Si l’utilisateur a cliqué sur "Envoyer" et que tout est valide
        if ($form->isSubmitted() && $form->isValid()) {

            // (Optionnel) récupère les données du formulaire
            $data = $form->getData();

            // Message de confirmation
            $this->addFlash('success', 'Votre message a bien été envoyé.');

            // Redirection (évite le renvoi du formulaire au refresh)
            return $this->redirectToRoute('app_contact');
        }

        // Affichage de la page
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
