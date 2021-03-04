<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipationController extends AbstractController
{
    /**
     * @Route("/participation", name="participation")
     */
    public function index(): Response
    {


        return $this->render('participation/index.html.twig', [
            'controller_name' => 'ParticipationController',
        ]);
    }




 /**
     * @Route ("concours/participer/{id}",name="participer")
     */
    public function participation (Participation $participation, ParticipationRepository $repository)
    {
        $user_id = $participation->getUser();
        $param = $repository->findUser();
        return $this->render('concours/participation.html.twig', [
            'user_id' => $user_id
        ]);
    }


}
