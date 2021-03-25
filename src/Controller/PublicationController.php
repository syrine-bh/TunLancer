<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Notification;
use App\Entity\Publication;
use App\Entity\Reaction;
use App\Entity\signaler;
use App\Entity\Utilisateur;
use App\Entity\Vues;
use App\Form\CommentaireType;
use App\Form\PublicationType;
use App\Form\SignalerType;
use App\Repository\PublicationRepository;
use Psr\Container\ContainerInterface;
use Rypsx\Ipapi\Ipapi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PublicationController extends AbstractController
{
    /**
     * @Route("/publications/", name="publications")
     */
    public function DisplayPublications(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $publications = $em->getRepository(Publication::class)->findAll();
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $notifications = $em->getRepository(Notification::class)->getNotifications($user->getId());
        $stories = $em->getRepository(Publication::class)->getStoriesDistinct();

        return $this->render('publication/DisplayPublications.html.twig', [
            'controller_name' => 'PublicationController',
            'publications' => $publications,
            'notifications' => $notifications,
            'stories' => $stories
        ]);
    }

    /**
     * @Route("/publications/Stories", name="stories")
     */
    public function DisplayStoriesAction(){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $storyusers = $em->getRepository(Publication::class)->getStoriesDistinct();
        $stories = $em->getRepository(Publication::class)->getStories();



        return $this->render('publication/Stories.html.twig', [
            'storyusers' => $storyusers,
            'stories' => $stories,
            'connected' => $user
        ]);


    }

    /**
     * @Route("/publications/Story/{idUtilisateur}", name="story")
     */
    public function DisplayUserStoriesAction($idUtilisateur){
        $em = $this->getDoctrine()->getManager();
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $storyusers = $em->getRepository(Publication::class)->getUserStoriesDistinct($idUtilisateur);
        $stories = $em->getRepository(Publication::class)->getUserStories($idUtilisateur);



        return $this->render('publication/Stories.html.twig', [
            'storyusers' => $storyusers,
            'stories' => $stories,
            'connected' => $user
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
        $vues = $em->getRepository(Vues::class)->getVues();

        $user = $em->getRepository(Utilisateur::class)->find(1);
        //ajout du commentaire
        $commentaire=new Commentaire();
        $commentaire->setPublication($publication);
        $commentaire->setIdUtilisateur($user);
        $Form=$this->createForm(CommentaireType::class,$commentaire);
        $Form->handleRequest($request);
        $trouv=0;
        $report=false;
        $reactions=$publication->getReactions();
        $signaux=$publication->getSignaux();
        foreach ($reactions as $reaction) {
            if ($reaction->getIdUtilisateur()->getId()==$user->getId()){
                $trouv=$reaction->getTypeReaction();
            }
        }

        foreach ($signaux as $signal) {
            if ($signal->getIdUtilisateur()->getId()==$user->getId()){
                $report=true;
            }
        }


        if ($Form->isSubmitted()&&$Form->isValid())/*verifier */
        {
            $publication->addCommentaire($commentaire);

            $notification =new Notification();
            $notification->setUtilisateur($publication->getIdU());
            $notification->setLien("publication:".$publication->getId());
            $notification->setDescription($user->getPrenom()." ".$user->getNom()." a commenté votre publication");
            $em->persist($notification);
            $em->persist($commentaire);
            $em->flush();
            return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
        }

        return $this->render('publication/detailPublication.html.twig', [
            'publication' => $publication,
            'commentaireform'=>$Form->createView(),
            'user' => $user,
            'isReact' => $trouv,
            'isReported' => $report,
            'vues' => $vues
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
        $publication->setArchive(0);
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
            'publicationform'=>$Form->createView(),
            'user' => $user
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
     * @Route("/publications/DeleteSignal/{idSignal}", name="delete_signal")
     */
    public function DeleteSignal($idSignal):Response
    {
        $em=$this->getDoctrine()->getManager();
        $signal=$em->getRepository(signaler::class)->find($idSignal);
        $em->remove($signal);
        $em->flush();
        return $this->redirectToRoute('reports');
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
        $user=$em->getRepository(Utilisateur::class)->find(2);
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

            $notification =new Notification();
            $notification->setUtilisateur($publication->getIdU());
            $notification->setLien("publication:".$publication->getId());
            $notification->setDescription($user->getPrenom()." ".$user->getNom()." a commenté votre publication");
            $em->persist($notification);
            $em->persist($react);
            $em->flush();
            return new JsonResponse("added");
        }
    }

    /**
     * @Route("/publication/addSignal/{idPublication}/{description}", name="Add_signal")
     */
    public function SignalerPublications($idPublication,$description)
    {
        $em = $this->getDoctrine()->getManager();
        $publication = $em->getRepository(Publication::class)->find($idPublication);
        $user = $em->getRepository(Utilisateur::class)->find(1);
        //signal
        $signaler=new signaler();
        $signaler->setPublication($publication);
        $signaler->setDescription($description);
        $signaler->setIdUtilisateur($user);
        $em->persist($signaler);
        $em->flush();

        return new JsonResponse("added");
    }


    /**
     * @Route("/publications/RemoveReaction/{idPublication}", name="RemoveReaction")
     */
    public function RemoveReaction($idPublication): Response
    {
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(Publication::class)->find($idPublication);
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $reactions=$publication->getReactions();
        foreach ($reactions as $reaction) {
            if(($reaction->getIdUtilisateur()->getId()==$user->getId()) && ($publication->getId()==$idPublication)){
                $em->remove($reaction);
                $em->flush();
            }
        }
        return $this->redirectToRoute('publication', ['idPublication' => $idPublication]);
    }


    /**
     * @Route("/dashboard/reports", name="reports")
     */
    public function DisplayReports(): Response
    {
        $em=$this->getDoctrine()->getManager();
        $signaux=$em->getRepository(signaler::class)->findAll();
        $pays=$em->getRepository(Vues::class)->GetPays();
        $regions=$em->getRepository(Vues::class)->GetRegions();
        $vues=$em->getRepository(Vues::class)->findAll();
        return $this->render('publication/Reports.html.twig', array(
            'signaux'=>$signaux,
            'pays'=>$pays,
            'regions'=>$regions,
            'count'=>sizeof($vues)
        ));
    }

    /**
     * @Route("/publication/GetIpAddressDetails/{ip}", name="GetIpAddressDetails")
     */
    public function GetIpAddressDetails($ip)
    {
        try {
            $ipapi = new Ipapi($ip);
        } catch (\Exception $e) {
            print $e->getMessage();
        }
        return new JsonResponse($ipapi);

    }

    /**
     * @Route("/publication/AddViewers/{idPublication}/{address}/{operateur}/{pays}/{code}/{region}/{ville}", name="AddViewers")
     */
    public function AddViewers($idPublication,$address,$operateur,$pays,$code,$region,$ville){

        $vu = new Vues();
        $em=$this->getDoctrine()->getManager();
        $user=$em->getRepository(Utilisateur::class)->find(1);
        $publication=$em->getRepository(Publication::class)->find($idPublication);

        $vues=$publication->getViewers();
        $trouv=false;
        foreach ($vues as $vue) {
            if ($vue->getUtilisateur()->getId()==$user->getId()){
                $sysDate = new \DateTime();
                $interval = $sysDate->diff($vue->getDate());
                if($interval->i<=5){
                    $trouv=true;
                }
            }
        }

        if($trouv==false){
            if ($publication->getIdU()->getId()==$user->getId()){
                return new JsonResponse("no add");
            }else{
                $vu->setUtilisateur($user);
                $vu->setPublication($publication);
                $vu->setAdresse($address);
                $vu->setOperateur($operateur);
                $vu->setPays($pays);
                $vu->setPaysCode($code);
                $vu->setRegion($region);
                $vu->setVille($ville);
                $em->persist($vu);
                $em->flush();
                return new JsonResponse("vu");
            }

        }else{
            return new JsonResponse("deja vu");
        }

    }


    /**
     * @Route("/dashboard/GetOperateurs", name="getOperateurs")
     */
    public function GetOperateurs()
    {
        $em=$this->getDoctrine()->getManager();
        $result=$em->getRepository(Vues::class)->getOperateurs();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $operateurs=$serializer->normalize($result);
        return new JsonResponse($operateurs);
    }


    /**
     * @Route("/dashboard/GetCountOperateurs", name="GetCountOperateurs")
     */
    public function GetCountOperateurs()
    {
        $em=$this->getDoctrine()->getManager();
        $vues=$em->getRepository(Vues::class)->findAll();
        return new JsonResponse(sizeof($vues));
    }


}