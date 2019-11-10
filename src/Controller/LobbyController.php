<?php

namespace App\Controller;

use App\Entity\Lobby;
use App\Entity\User;
use App\Form\LobbyType;
use App\Repository\LobbyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Datetime;

/**
 * @Route("/lobby")
 */
class LobbyController extends AbstractController
{
    /**
     * @Route("/", name="lobby_index", methods={"GET"})
     */
    public function index(LobbyRepository $lobbyRepository): Response
    {
        return $this->render('lobby/index.html.twig', [
            'lobbies' => $lobbyRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="lobby_index_active", methods={"GET"})
     */
    public function indexActive(LobbyRepository $lobbyRepository): Response
    {
        return $this->render('lobby/index_active.html.twig', [
            'lobbies' => $lobbyRepository->findAll(),
        ]);
    }
    /**
     * @Route("/", name="lobby_index_inactive", methods={"GET"})
     */
    public function indexInactive(LobbyRepository $lobbyRepository): Response
    {
        return $this->render('lobby/index_inactive.html.twig', [
            'lobbies' => $lobbyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lobby_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lobby = new Lobby();
        $form = $this->createForm(LobbyType::class, $lobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dump($request);
            $session=$this->get('session');
            $user = $session->get('account');
            $entityManager = $this->getDoctrine()->getManager();
            $lobby->setCreatedAt(new Datetime());
            $entityManager->persist($lobby);
            $entityManager->flush();

            return $this->redirectToRoute('lobby_index');
        }

        return $this->render('lobby/new.html.twig', [
            'lobby' => $lobby,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lobby_show", methods={"GET"})
     */
    public function show(Lobby $lobby): Response
    {

        $users = $lobby->getUser();
        dump($users);
        $usersName=[];
        foreach($users as $user){
            $usersName[]=$user->getLastname();
        }
        dump($usersName);
        $ur = $this->getDoctrine()->getRepository(User::class);

        return $this->render('lobby/show.html.twig', [
            'lobby' => $lobby,
            "users" => $users
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lobby_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Lobby $lobby): Response
    {
        $form = $this->createForm(LobbyType::class, $lobby);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lobby_index');
        }

        return $this->render('lobby/edit.html.twig', [
            'lobby' => $lobby,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lobby_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lobby $lobby): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lobby->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lobby);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lobby_index');
    }
}
