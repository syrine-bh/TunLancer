<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Entity\Concour;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route ("/concour/listParticipants/{id}",name="listParticipants")
     */
    public function getPart(Concour $concour, ParticipationRepository  $rep )
    {
        $test=$rep->FindByConcId($concour->getId());
        return $this->render('concour/listParticipants.html.twig',['participant'=>$test]);

    }

    /**
     * @Route ("/concour/listTTParticipants",name="listTTParticipants")
     */
    public function getTTPart( ParticipationRepository  $rep )
    {
        $test=$rep->findAll();
        return $this->render('participation/listTTParticipants.html.twig',['participation'=>$test]);

    }


}
