<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SoundRepository;
use App\Repository\StyleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CatalogueController extends AbstractController
{
    #[Route('/catalogue', name: 'app_catalogue')]
    public function index(
        Request $request,
        SoundRepository $soundRepository,
        CategoryRepository $categoryRepository,
        StyleRepository $styleRepository,
    ): Response {
        $categoryId = $request->query->getInt('category') ?: null;
        $styleId    = $request->query->getInt('style') ?: null;

        $sounds     = $soundRepository->findByFilters($categoryId, $styleId);
        $categories = $categoryRepository->findAll();
        $styles     = $styleRepository->findAll();

        return $this->render ('catalogue/index.html.twig', [
            'sounds'           => $sounds,
            'categories'       => $categories,
            'styles'           => $styles,
            'activeCategoryId' => $categoryId,
            'activeStyleId'    => $styleId,
        ]);
    }
}
