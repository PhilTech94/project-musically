<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, on le redirige vers l'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Récupère l'erreur de connexion s'il y en a une (mauvais mot de passe, etc.)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Pré-remplit le champ email avec la dernière valeur saisie
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    // Symfony gère la déconnexion automatiquement via security.yaml
    // Cette méthode ne sera jamais exécutée mais la route doit exister
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void {}
}
