<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="security_inscri")
     * @Route("/user/edit/{id}", name="edit_user")
     */
    public function registration(User $user=null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$user){
            $user = new User();
        }
        
        $user->setRoles(array('ROLE_USER'));
        
        $form = $this->createForm(RegistrationType::class,$user);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $manager->persist($user);   
            $manager->flush();
            
            return $this->redirectToRoute('security_connect');
            
        }
        return $this->render('security/inscription.html.twig', [
            'form'=>$form->createView(),
            'editMode' => $user->getId() !== null
        ]);
    }
    
    
    /**
     * @Route("/connexion", name="security_connect")
     */
    public function login(){
        return $this->render('security/login.html.twig');
    }
    
    
    /**
     * @Route("/deconnexion", name="security_deco")
     */
    public function logout(){
    }
    
    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/users", name="users")
     */
    public function users(UserRepository $repo){
        $users = $repo->findAll();
        return $this->render('security/users.html.twig',[
            'users'=>$users
        ]);
        
    }
}
