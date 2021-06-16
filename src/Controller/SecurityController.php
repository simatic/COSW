<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RegistrationType;
use App\Entity\Session;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
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
    
    /* ça sera ce lien qui sera envoyé au pairs,
     * Il permets de trouver l'utilisateuer avec le uid puis de le connecter
     * ensuite de trouver la session avec uidSession et de le rediriger vers 
     * la page de la session*/
    /**
     * @Route("/login/{uid}/{uidSession}", name="login_with_uid")
     */
    public function login_pair(String $uidSession, String $uid,EntityManagerInterface $manager, LoginFormAuthenticator $login, GuardAuthenticatorHandler $guard, Request $request){
        $user = $manager->getRepository(User::class)->findOneBy([
            'uid'=>$uid
        ]);
        if(isset($user)){
            dump("Erreur finding user");
        }
        $guard->authenticateUserAndHandleSuccess($user, $request, $login, 'main');
        
        $session = $manager->getRepository(Session::class)->findBy(['uid'=>$uidSession]);
        
        if(isset($session)){
            return $this->redirect($this->generateUrl('session_user', array('uid' => $uidSession)));
        }
        return $this->render('session/show.html.twig',[
            'session'=>$session
        ]
            );
        
    }
    
}
