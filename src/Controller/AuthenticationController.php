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
                $phone=$request->request->get('phone');
                $password=$request->request->get('password');
                if(!preg_match('#^.[0-9]{9}$#', $phone)){
                    $errors['phone'] =  true;
                }
                if(!preg_match('#^.{5,320}$#i', $password)){
                    $errors['password'] = true;
                }
                if(!isset($errors))
                {
                    $ur = $this->getDoctrine()->getRepository(User::class);
                    $user = $ur->findOneByPhone($phone);
                    dump($user);
                    if(!empty($user))
                    {
                        
                        $passwordVerif = $user->getPassword();
                        if($password == $passwordVerif){
                            $session->set('account', $user);
                            return $this->render('login.html.twig', array('success' => true));
                        }else{
                            return $this->render('login.html.twig', array('errorPassword' => true));

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
