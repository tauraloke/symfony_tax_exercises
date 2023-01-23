<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Cart;
use App\Form\Type\CartType;
use App\Repository\ProductRepository;
use App\Repository\VatinRepository;
use App\Util\VatinAnalyzer;

class CartController extends AbstractController
{
    public function order(): Response
    {
        $cart = new Cart();
        $cart->setVatin('');
        $cart->setCart([]);

        $form = $this->createForm(CartType::class, $cart, [
            'action' => $this->generateUrl('app_cart_total'),
            'method' => 'POST',
        ]);

        return $this->render('products/cart.html.twig', [
            'form' => $form->createView()
        ]);
    }

    public function total(Request $request): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $goods = $data->getCart();

            $vatin_medatada = (new VatinAnalyzer($data->getVatin()))->getMetadata();

            return $this->render('products/total.html.twig', [
                'form' => $form,
                'goods' => $goods
            ]);
        }



        return $this->render('products/cart.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}