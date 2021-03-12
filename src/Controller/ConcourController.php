<?php

namespace App\Controller;

use App\Entity\Concour;
use App\Entity\Participation;
use App\Entity\Score;
use App\Entity\User;
use App\Form\ConcoursType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcourController extends AbstractController
{
    /**
     * @Route("/concour", name="concour")
     */
    public function index(): Response
    {
        return $this->render('concour/list.html.twig', [
            'controller_name' => 'ConcourController',
        ]);
    }

    /**
     * @return Response
     * @Route ("/concour/list",name="list")
     */
    public function list (){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->findAll();
        return $this->render('concour/list.html.twig',['concour'=>$concours]);
    }

    /**
     * @Route ("/concour/descriptionConcours/{id}",name="descriptionConcours")
     */
    public function descriptionConcours($id){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concour=$repo->findAll();
        return $this->render('/concour/descriptionConcours.html.twig',[
            'concour'=>$concour
        ]);
    }

    /**
     * @return Response
     * @Route ("/concour/listCadmin",name="listCadmin")
     */
    public function listCadmin (){
        $repo=$this->getDoctrine()->getRepository(Concour::class);
        $concours=$repo->findAll();
        return $this->render('concour/listCadmin.html.twig',['concour'=>$concours]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("concour/ajoutCadmin",name="ajoutCadmin")
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
        return $this->render("concour/ajouterConcours.html.twig",[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("concour/modifierConcours{id}",name="modifierConcours")
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
        return $this->render("concour/modifierConcours.html.twig",[
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

    /**
     * @param Request $request
     * @return Response
     * @Route ("concour/ajouterConcours",name="ajouterConcours")
     */
    public function ajouterConcours (Request $request){
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
        return $this->render("concour/ajouterConcours.html.twig",[
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @return Response
     * @Route ("/concour/listPadmin",name="listPadmin")
     */
    public function listPadmin(){
        $repo=$this->getDoctrine()->getRepository(Participation::class);
        $participation=$repo->findAll();
        return $this->render('concour/listPadmin.html.twig',['participation'=>$participation]);
    }

    /**
     * @Route("admin/promoteModifConcour/{id}", name="promoteModifConcour")
     * @param User $id
     * @return Response
     *
     */
//    public function promoteModifConcour($id)
//    {
//
//        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
//        $message = (new \Swift_Message('Modification date concours'))
//            ->setFrom('tunlancer.coders@gmail.com')
//            ->setTo($user->getEmail());
//        $message->setBody(
//            '<html>' .
//            ' <body>' .
//            '  Congrats <img src="' .
//            $message->embed(Swift_Image::fromPath('D:\Projects\PIDev\web\assets\img\congrats.jpg')) .
//            '" alt="Image" />' .
//            '  You earned a Talented Account' .
//            ' </body>' .
//            '</html>',
//            'text/html');
//        $this->get('mailer')->send($message);
//        $talented->setRoles(['ROLE_TALENTED']);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($talented);
//        $em->flush();
//        return $this->redirectToRoute('admin_competition_index');
//
//
//    }


}