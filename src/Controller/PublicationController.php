<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\Reaction;
use App\Entity\Utilisateur;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publications/", name="publications")
     */
    public function DisplayPublications(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository(Publication::class)->findAll();
        return $this->render('publication/DisplayPublications.html.twig', [
            'controller_name' => 'PublicationController',
            'publications' => $publications
        ]);
    }

    /**
     * @Route("/publication/{idPublication}", name="publication")
     */
    public function DetailsPublications(Request $request,$idPublication): Response
    {
        //detail publication
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository(Publication::class)->find($idPublication);
        $user = $em->getRepository(Utilisateur::class)->find(1);
        //ajout du commentaire
        $commentaire=new Commentaire();
        $commentaire->setPublication($publication);
        $commentaire->setIdUtilisateur($user);
        $Form=$this->createForm(CommentaireType::class,$commentaire);
        $Form->handleRequest($request);
        $trouv=0;
        $reactions=$publication->getReactions();
        foreach ($reactions as $reaction) {
            if ($reaction->getIdUtilisateur()->getId()==$user->getId()){
                $trouv=$reaction->getTypeReaction();
            }
        }

        if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
        {
            $publication->addCommentaire($commentaire);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
        }

        return $this->render('publication/detailPublication.html.twig', [
            'publication' => $publication,
            'commentaireform'=>$Form->createView(),
            'user' => $user,
            'isReact' => $trouv
        ]);
    }

    /**
     * @Route("/publications/Add", name="add_publication")
     */
    public function Add(Request $request): Response
    {
        $publication=new Publication();
        $user=$em=$this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find(1);
        $publication->setIdU($user);
        $Form=$this->createForm(PublicationType::class,$publication);
        $Form->handleRequest($request);

        if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $this->redirectToRoute('publications');
        }
        return $this->render('publication/AddPublication.html.twig', array(
            'publicationform'=>$Form->createView()
        ));
    }


    /**
     * @Route("/publications/DeletePublication/{idPublication}", name="delete_Publication")
     */
    public function DeletePublication($idPublication):Response
    {
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(publication::class)->find($idPublication);
        $em->remove($publication);
        $em->flush();
        return $this->redirectToRoute('publications');
    }

    /**
     * @Route("/publications/UpdatePublication/{idPublication}", name="update_Publication")
     */
    public function UpdatePublication($idPublication,Request $request):Response
{
    $em=$this->getDoctrine()->getManager();
    $publication=$em->getRepository(publication::class)->find($idPublication);
    $Form=$this->createForm(PublicationType::class,$publication);
    $Form->handleRequest($request);
    if ($Form->isSubmitted())
    {
        $em->flush();
        return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
    }
    return $this->render('publication/UpdatePublication.html.twig', array(
        'publicationform'=>$Form->createView()
    ));
}

    /**
     * @Route("/publications/addCommentaire/{idPublication}", name="add_commentaire")
     */
    public function AddCommentaire(int $idPublication,Request $request): Response{
        $commentaire=new Commentaire();
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(Publication::class)->find($idPublication);
        $user = $em->getRepository(Utilisateur::class)->find(1);
        if ($publication==null){
            echo "publication not found";
        }else{
            $commentaire->setPublication($publication);
            $commentaire->setIdUtilisateur($user);
            $Form=$this->createForm(CommentaireType::class,$commentaire);
            $Form->handleRequest($request);
            if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
            {
                $publication->addCommentaire($commentaire);
                $em->persist($commentaire);
                $em->flush();
                return $this->redirectToRoute('publications');
            }
            return $this->render('commentaire/AddCommentaire.html.twig', array(
                'commentaireform'=>$Form->createView()
            ));
        }



    }

    /**
     * @Route("/publications/DeleteCommentaire/{idPublication}/{idCommentaire}", name="Deletecommentaire")
     */
    public function DeleteCommentaire($idPublication,$idCommentaire)
    {
        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($idCommentaire);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
    }

    /**
     * @Route("/publications/UpdateCommentaire/{idPublication}/{idCommentaire}", name="UpdateCommentaire")
     */
    public function UpdateCommentaire($idPublication,$idCommentaire,Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $commentaire=$em->getRepository(Commentaire::class)->find($idCommentaire);
        $Form=$this->createForm(CommentaireType::class,$commentaire);
        $Form->handleRequest($request);
        if ($Form->isSubmitted())
        {
            $em->flush();
            return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
        }
        return $this->render('commentaire/UpdateCommentaire.html.twig', array(
            'commentaireform'=>$Form->createView()
        ));
    }






    /**
     * @Route("/publication/AddReaction/{idPublication}/{type}", name="AddReaction")
     */
    public function ReactAction($idPublication,$type){
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(Publication::class)->find($idPublication);
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $trouv=false;
        $reactions=$publication->getReactions();
        foreach ($reactions as $reaction) {
            if ($reaction->getIdUtilisateur()->getId()==$user->getId()){
                $trouv=true;
            }
        }

        if ($trouv==true){
            return new JsonResponse("exists");
        }else{
            $react=new Reaction();
            $react->setPublication($publication);
            $react->setIdUtilisateur($user);
            $react->setTypeReaction($type);
            $em->persist($react);
            $em->flush();
            return new JsonResponse("added");
        }
    }



    /**
     * @Route("/publications/RemoveReaction/{idReaction}", name="RemoveReaction")
     */
    public function RemoveReaction($idReaction): Response
    {
        $em=$this->getDoctrine()->getManager();
        $reaction=$em->getRepository(Reaction::class)->find($idReaction);
        $em->remove($reaction);
        $em->flush();
        return $this->redirectToRoute('publications');
    }



}