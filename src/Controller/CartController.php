<?php

namespace App\Controller;

use App\Repository\SoundRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    public function __construct(private RequestStack $requestStack) {}

    #[Route('/add/{id}', name: 'add', methods: ['POST'])]
    public function add(int $id, SoundRepository $soundRepository): JsonResponse
    {
        $sound = $soundRepository->find($id);
        if (!$sound) {
            return $this->json(['error' => 'Son introuvable'], 404);
        }

        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $cart[$id] = ($cart[$id] ?? 0) + 1;
        $session->set('cart', $cart);

        return $this->json([
            'success'   => true,
            'cartCount' => array_sum($cart),
        ]);
    }

    #[Route('/remove/{id}', name: 'remove', methods: ['POST'])]
    public function remove(int $id): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        unset($cart[$id]);
        $session->set('cart', $cart);

        return $this->json([
            'success'   => true,
            'cartCount' => array_sum($cart),
        ]);
    }

    #[Route('/update/{id}', name: 'update', methods: ['POST'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);
        $quantity = max(1, (int) $request->request->get('quantity', 1));
        $cart[$id] = $quantity;
        $session->set('cart', $cart);

        return $this->json([
            'success'   => true,
            'cartCount' => array_sum($cart),
        ]);
    }

    #[Route('/data', name: 'data', methods: ['GET'])]
    public function data(SoundRepository $soundRepository): JsonResponse
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get('cart', []);

        $items = [];
        $total = 0.0;

        foreach ($cart as $id => $quantity) {
            $sound = $soundRepository->find($id);
            if (!$sound) {
                continue;
            }

            $price    = $sound->getPrice() / 100;
            $subtotal = $price * $quantity;
            $total   += $subtotal;

            $items[] = [
                'id'       => $id,
                'name'     => $sound->getName(),
                'price'    => $price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
                'category' => $sound->getCategory()?->getName(),
                'style'    => $sound->getStyle()?->getName(),
            ];
        }

        return $this->json([
            'items' => $items,
            'total' => $total,
            'count' => array_sum($cart),
        ]);
    }
}
