<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Category;
use App\Form\SearchProduitType;
use App\Repository\ProduitRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ShopController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(): Response
    {
        return $this->render('shop/home.html.twig');
    }
    /**
     * @Route("/categories", name="categories")
     */
    public function categories(CategoryRepository $repo): Response
    {
        $categories = $repo->findAll();
        return $this->render('shop/categories.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/produitParCategorie/{id}", name="produitParCategorie")
     */
    public function produitParCategorie(CategoryRepository $repo, int $id): Response
    {
        $category = $repo->find($id);
        $All = $category->getProduits();

        return $this->render('shop/produits.html.twig', [

            'All' => $All
        ]);
    }
    /**
     * @Route("/produits", name="produits")
     */
    public function produits(ProduitRepository $repo,Request $request): Response
    {

        $All = $repo->findAll(['brand'=>'asc']);
        $form = $this->createForm(SearchProduitType::class);
        $search = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            //On recherche les annonces correspodant aux mots clé<s class=""></s>
            $All = $repo->search(
                $search->get('mots')->getData(),
                $search->get('categorie')->getData()

            );

        }
        return $this->render('shop/produits.html.twig', [
            'All' => $All,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/produit/{id}", name="produit")
     */
    public function produit(Produit $produit): Response
    {
        return $this->render('shop/produit.html.twig', [
            'produit' => $produit
        ]);
    }
    /**
     * @Route("/readme", name="readme")
     */
    public function readme(): Response
    {
        return $this->render('markdown/readme.markdown.twig');
    }


}
