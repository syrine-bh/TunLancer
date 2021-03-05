<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Form\ParticipationType;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Concour;
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
     * @return Response
     * @Route ("/concours/listPadmin",name="listPadmin")
     */
    public function listPadmin (){
        $repo=$this->getDoctrine()->getRepository(Participation::class);
        $participation=$repo->findAll();
        return $this->render('concour/listPartAdmin.html.twig',['participation'=>$participation]);
    }


    /**
     * @Route ("participation/ajouterParticipant",name="ajouterParticipant")
     */
    public function ajouterParticipant (Request $request){
        $participation=new Participation();
        $form=$this->createForm(ParticipationType::class,$participation);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('listTTParticipants');
        }
        return $this->render("participation/addPart.html.twig",[
            'form'=>$form->createView(),
        ]);
    }


    /**
     * @Route ("participation/ajouterParticipant",name="ajouterParticipant")
     */
    public function editParticipant (Request $request){
        $participation=new Participation();
        $form=$this->createForm(ParticipationType::class,$participation);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($participation);
            $em->flush();
            return $this->redirectToRoute('listTTParticipants');
        }
        return $this->render("participation/addPart.html.twig",[
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route ("participation/modifierParticipant{id}",name="modifierParticipant")
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifierParticipant($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Participation::class);
        $participation=$repo->find($id);
        $form=$this->createForm(ParticipationType::class,$participation);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listTTparticipants');
        }
        return $this->render("participation/modifierParticipant.html.twig",[
            'form'=>$form->createView(),
        ]);
    }


}
