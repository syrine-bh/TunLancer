<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        return $this->render('publication/index.html.twig', [
            'controller_name' => 'PublicationController',
            'result' => $publications
        ]);
    }

    /**
     * @Route("/publications/Add", name="add_publication")
     */
    public function Add(Request $request): Response
    {
        $publication=new Publication();
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
     * @Route("/publications/addCommentaire/{idPublication}", name="add_commentaire")
     */
    public function AddCommentaire(int $idPublication,Request $request): Response{
        $commentaire=new Commentaire();
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(Publication::class)->find($idPublication);
        if ($publication==null){
            echo "publication not found";
        }else{
            $commentaire->setPublication($publication);
            $commentaire->setIdUtilisateur(1);
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
     * @Route("/publications/removeCommentaire/{idPublication}", name="remove_commentaire")
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
     * @Route("/publications/updateCommentaire/{idPublication}", name="update_commentaire")
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
        return $this->redirectToRoute('publications');
    }
    return $this->render('publication/UpdatePublication.html.twig', array(
        'publicationform'=>$Form->createView()
    ));
}
}
