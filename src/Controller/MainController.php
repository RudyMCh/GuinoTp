<?php

namespace App\Controller;

use App\Entity\Lobby;
use App\Entity\User;
use App\Entity\Doc;
use App\Entity\Message;
use App\Form\FileType;
use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \DateTime;


class MainController extends AbstractController{
    /**
     * @route("/", name="index")
     */
    public function index()
    {
        // $ur = $this->getDoctrine()->getRepository(User::class);
        // $lr = $this->getDoctrine()->getRepository(Lobby::class);
        // $user = $ur->findOneById();
        // dump($user);
        // $lobby = $lr->findOneById(4);
        // dump($lobby);
        // foreach($lobby as $lob){
        //     dump($lob->getName());
        // }
        // $lobby->addUser($user);
        // dump($lobby->getUsers());
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($lobby);
        // $em->flush();
        return $this->render('index.html.twig');
    }

    /**
     * @Route("tchat/{id}", name="tchat", requirements={"id"="[1-9][0-9]{0,10}"})
     */
    public function tchat($id, Request $request)
    {
        $session = $this->get('session');
        if(!$session->has('account')){
            //si pas connecté, rejetté
            return $this->redirectToRoute('login');
        }else{
            $lr = $this->getDoctrine()->getRepository(Lobby::class);
            $lobby = $lr->findOneById($id);
            if(!$lobby->getActive()){
                throw new NotFoundHttpException('Salon inactif');
            }
            $user = $session->get('account');
            $docs = $lobby->getDocs();
            $messages = $lobby->getMessages();
            $users = $lobby->getUser();
            if($request->isMethod("post")){
                $content=$request->request->get('message');
                $lobbyId=$request->request->get('id');
                $lr=$this->getDoctrine()->getRepository(Lobby::class);
                $lobby = $lr->findOneById($lobbyId);
                dump($content);
                $em = $this->getDoctrine()->getManager();
                $message = new Message();
                $message->setContent($content);
                $message->setCreatedAt(new DateTime);
                $message->setUser($user);
                $message->setLobby($lobby);
                $em->persist($message);
                $em->flush();
                return $this->render('tchat.html.twig', ["success" => true, "id" => $id, "messages" => $messages, "docs" => $docs, "users" => $users]);
            }


            return $this->render('tchat.html.twig', ["id" => $id, "messages" => $messages, "docs" => $docs, "users" => $users]);

        }
    }

    /**
     * @Route("mes-salons", name="myLobbies")
     */
    public function myLobbies()
    {
        $session = $this->get('session');
        $user = $session->get('account');
        $em = $this->getDoctrine()->getManager();
        $user = $em->merge($user);
        $myLobbies = $user->getLobbies();
        dump($user);
        dump($myLobbies);

        return $this->render('myLobbies.html.twig', ["myLobbies" => $myLobbies]);
    }

    /**
     * @Route("/associer-utilisateur", name="assoc")
     */
    public function assoc(Request $request)
    {   
        $session = $this->get('session');
        $user = $session->get('account');
        $ur = $this->getDoctrine()->getRepository(User::class);
        $lr = $this->getDoctrine()->getRepository(Lobby::class);
        $users = $ur->findAll();
        $lobbies = $lr->findAll();

        if($request->isMethod('POST')){
            $userId = $request->request->get('id');
            $lobbyName = $request->request->get('lobby');
            dump($lobbyName);
            $userLobby = $ur->findOneById($userId);
            $lobby = $lr->findOneByName($lobbyName);
            dump($lobby);
            dump($userLobby);
            $lobby->addUser($userLobby);
            $em = $this->getDoctrine()->getManager();
            $em->persist($lobby);
            $em->persist($userLobby);
            $em->flush();

            return $this->render("assocUserLobby.html.twig", [
                "lobbies" => $lobbies,
                "users" => $users,
                "success" => true
            ]);
        }
        return $this->render("assocUserLobby.html.twig", [
            "lobbies" => $lobbies,
            "users" => $users
        ]);
    }


}