<?php

namespace App\Controller;

use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


    /**
     * Require ROLE_USER for *every* controller method in this class.
     *
     * @IsGranted("ROLE_USER")
     */
class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart")
     */
    public function index(CartService $cartService): Response
    {
       // dd($panierWithData);

        return $this->render('cart/index.html.twig',
            ['items'=>$cartService->getFullCart(),
            'total'=>$cartService->getTotal()   
            ]);
    }

    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */

    public function add($id, CartService $cartService){
        $cartService->add($id);
        return $this->redirectToRoute('cart');
    }

   /**
     * @Route("/cart/remove/{id}", name="cart_remove")
     */

    public function remove($id, CartService $cartService){

        $cartService->remove($id);
        return $this->redirectToRoute('cart');
    }
    /**
     * @Route("/cart/validate", name="cart_validate")
     */

    public function cartValidate(CartService $cartService){

        $cartService->validateCart();
        $this->addFlash('success', 'Merci pour votre achat');
        return $this->redirectToRoute('cart');
    }
}
