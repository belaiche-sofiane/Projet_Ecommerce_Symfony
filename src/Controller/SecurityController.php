<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionFormType;
use App\Security\ConnexionFormAthentificatorAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function inscription(Request $request, EntityManagerInterface $manager, 
    UserPasswordEncoderInterface $encoder,
    ConnexionFormAthentificatorAuthenticator $login,
    GuardAuthenticatorHandler $guard): Response
    {
       $user = new User();
       $insriptionForm = $this->createForm(InscriptionFormType::class, $user);
       $insriptionForm->handleRequest($request);
       if( $insriptionForm->isSubmitted() && $insriptionForm->isValid()){

            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $user->setRoles(['ROLE_USER']);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash('success', 'Inscription réussie, BRAVO !!!');
            return $guard->authenticateUserAndHandleSuccess($user,$request,$login,'main');
       }
       
       
       return $this->render('security/inscription.html.twig',[
           'inscriptionForm'=>$insriptionForm->createView()
       ]);
    }
    
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion()
    {

    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
}
