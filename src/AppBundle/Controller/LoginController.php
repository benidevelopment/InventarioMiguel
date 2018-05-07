<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/*-----------------------------------*/
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginController extends Controller
{
     /**
     * @Route("/login", name="login_seguridad")
     *
     */
    public function loginAction(Request $request)
    {
        //Creo el formulario
        $formulario=$this->createFormBuilder()
        ->add("username",TextType::class , array('attr' => array('placeholder' => 'DNI'))) 
        ->add("password",PasswordType::class , array('attr' => array('placeholder' => 'Password'))) 
        ->add("Login",SubmitType::class , array('attr' => array('class' => 'btn  btn-sm')))
        ->getForm();
     //comprobando porque no funciona el formulario
       var_dump($formulario);

       $autenticacionUtils=$this->get('security.authentication_utils');

       $error=$autenticacionUtils->getLastAuthenticationError();

       return $this->render("Login/Login.html.twig",
    ["error"=>$error,"formulario"=>$formulario->createView()]);
    }

    /**
     * @Route("/login_check", name="login_check_seguridad")
     *
     * @return void
     */
    public function loginCheckAction()
    {
      
    }

    /**
     * @Route("/logout", name="logout")
     * 
     */
    public function logoutAction(){

    }

    /**
     * @Route("/loginRedirec", name="loginRedirec")
     *
     * @return void
     */
    public function loginRedirec(){

        $Usuario = get_current_user();

        if ($this->isGranted('ROLE_PROF')){
            
            return $this->redirectToRoute('articulo');
        }

    }


}
