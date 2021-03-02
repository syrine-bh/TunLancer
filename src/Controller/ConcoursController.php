<?php

namespace App\Controller;

use App\Entity\Concour;
use App\Form\ConcoursType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcoursController extends AbstractController
{
    /**
     * @Route("/concours", name="concours")
     */
    public function index(): Response
    {
        return $this->render('concours/list.html.twig', [
            'controller_name' => 'ConcoursController',
        ]);
    }

    /**
     * @return Response
     * @Route ("/concours/list",name="list")
     */
    public function list (){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->findAll();
        return $this->render('concours/list.html.twig',['concours'=>$concours]);
    }

     /**
     * @Route ("/concours/descriptionConcours",name="descriptionConcours")
     */
        public function descriptionConcours(){
            $repo=$this->getDoctrine()->getRepository(Concour::class);
            $description=$repo->findAll();
            return $this->render('/concours/descriptionConcours.html.twig',[
                'description'=>$description
            ]);
        }

    /**
     * @return Response
     * @Route ("/concours/listCadmin",name="listCadmin")
     */
    public function listCadmin (){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->findAll();
        return $this->render('concours/listCadmin.html.twig',['concours'=>$concours]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("concours/ajoutCadmin",name="ajoutCadmin")
     */
    public function ajoutConcours (Request $request){
        $concours=new Concour();
        $form=$this->createForm(ConcoursType::class,$concours);
        $form->add('Ajouter',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($concours);
            $em->flush();
            return $this->redirectToRoute('listCadmin');
        }
        return $this->render("concours/ajoutConcours.html.twig",[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("concours/modifierConcours{id}",name="modifierConcours")
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->find($id);
        $form=$this->createForm(ConcoursType::class,$concours);
        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listCadmin');
        }
        return $this->render("concours/modifierConcours.html.twig",[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route ("/supprimerConcours/{id}",name="supprimerConcours")
     */
    public function supprimerConcours($id){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($concours);
        $em->flush();
        return $this->redirectToRoute('listCadmin');
    }

}
