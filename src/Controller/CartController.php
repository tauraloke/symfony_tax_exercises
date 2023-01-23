<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Cart;
use App\Entity\Product;
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
            $tax_rate = $vatin_medatada['tax_rate'];

            $total = array_reduce(
                $goods,
                fn($carry, Product $item) => $carry + $item->getPrice(),
                0
            );

            $total_with_vat = $total * (100 + $tax_rate) / 100;

            $vat_of_total = ($tax_rate / 100) * $total;

            return $this->render('products/total.html.twig', [
                'form' => $form,
                'goods' => $goods,
                'country' => $vatin_medatada['country'],
                'tax_rate' => $tax_rate,
                'total_with_vat' => $total_with_vat,
                'vat_of_total' => $vat_of_total,
            ]);
        }



        return $this->render('products/cart.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}