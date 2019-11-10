<?php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \DateTime;
use \DateInterval;
use App\Entity\User;


/**
 * @Route("/")
 */
class AuthenticationController extends AbstractController{
/**
     * @Route("/se-connecter/", name="login")
     */
    public function login(Request $request)
    {
        $session=$this->get('session');
        if($session->has('account')){
            return $this->redirectToRoute('home');
        }else{
            if
            (
                $request->isMethod('POST')
            )
            {
                $email=$request->request->get('email');
                $password=$request->request->get('password');
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $errors['email'] =  true;
                }
                if(!preg_match('#^.{8,320}$#i', $password)){
                    $errors['password'] = true;
                }
                if(!isset($errors))
                {
                    $ur = $this->getDoctrine()->getRepository(User::class);
                    $user = $ur->findOneByEmail($email);
                    dump($user);
                    if(!empty($user))
                    {
                        
                        $passwordVerif = $user->getPassword();
                        if($password == $passwordVerif){
                            $session->set('account', $user);
                            return $this->render('login.html.twig', array('success' => true));
                        }
                    }
                }
            }
            if(isset($errors)){
                return $this->render("login.html.twig", array("errors" => $errors));
            }else{
                return $this->render("login.html.twig");
            }
        }
    }

        /**
     * @Route("/se-deconnecter/", name="logout")
     */
    public function logout(){
        $session=$this->get('session');
        if($session->has('account')){
            $session->remove('account');
            return $this->render('logout.html.twig');
        }else{
            return $this->redirectToRoute('login');
        }
    }
}
