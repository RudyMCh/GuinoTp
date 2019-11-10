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
class ApiController extends AbstractController{

    /**
     * @Route("ajax-message", name="ajaxMessage")
     */
    public function ajaxMessage(Request $request)
    {
        $session=$this->get('session');
        $user = $session->get('account');
        if($request->isMethod('post')){
            $content=$request->request->get('message');
            $lobbyId=$request->request->get('id');
            if(!preg_match('#^.{0,255}$#i', $content)){
                $errors['content']= true;
            }
            if(!preg_match('#^[0-9]{0,11}$#i', $id)){
                $errors['id']= true;
            }
            if(!isset($errors)){

                dump($content);
                dump($id);
            $lr=$this->getDoctrine()->getRepository(Lobby::class);
            $lobby = $lr->findOneById($lobbyId);
            $em = $this->getDoctrine()->getManager();
            $message = new Message();
            $message->setContent($content);
            $message->setCreatedAt(new DateTime);
            $message->setUser($user);
            $message->setLobby($lobby);
            $em->persist($message);
            $em->flush();
            //return $this->json(["success" => true]);
            }
            if(isset($errors)){
                return $this->json(["errors" => $errors]);
            }

        }
    }
}