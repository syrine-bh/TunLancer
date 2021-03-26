<?php

namespace App\Controller;

use App\Entity\Concour;
use App\Entity\Participation;
use App\Entity\Score;
use App\Entity\User;
use App\Entity\Video;
use App\Form\ConcoursType;
use App\Form\VideoType;
use Doctrine\Common\Collections\ArrayCollection;
//use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ConcourController extends AbstractController
{
//    /**
//     * @Route("/concour", name="concour")
//     */
//    public function index(): Response
//    {
//        return $this->render('concour/list.html.twig', [
//            'controller_name' => 'ConcourController',
//        ]);
//    }

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
     * Creates a new competition entity.
     *
     * @Route("concourV/participate/{id}", name="concourV", requirements={"id":"\d+"}))
     * @param Request $request
     * @param concour $id
     * @return RedirectResponse|Response
     */
    public function newVideoAction(Request $request, concour $id)
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $concour = $this->getDoctrine()->getRepository(Concour::class)->find($id);

        $participation = $this->getDoctrine()->getRepository(Participation::class)->findByUser($this->getUser());
        $m = $participation = $this->getDoctrine()->getRepository(Participation::class)->findBy(['user' => $this->getUser(), 'concour' => $concour]);
//        if (($m != null) || in_array('ROLE_TALENTED',
//                $this->getUser()->getRoles()))
//        return $this->redirectToRoute('competition_index');
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        $link = "https://www.youtube.com/embed/";
        if ($form->isSubmitted() && $form->isValid()) {
            $video->setOwner($this->getUser());
            $url = $video->getUrl();
            $link = $link . substr($url, -11);
            $video->setUrl($link);
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $participation = new Participation();
            $user = $this->getUser();
            $participation->setConcour($concour);
//            $participation->setParticipationDate($video->getPublishDate());
            $participation->setUser($user);
            $participation->setVideo($video);
            $em->persist($participation);
            $em->flush();

            return $this->redirectToRoute('list');
        }

        return $this->render('concour/participationVideo.html.twig', array(
            'video' => $video, 'participant' => $participation,
            'concour'=>$concour,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/concourV/{id}", name="concourVlist")
     * @param concour $id
     * @return Response
     */
    public function show($id, Request $request)
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $paginator = $this->get(PaginatorInterface::class);
        $concour = $this->getDoctrine()->getRepository(Concour::class)->find($id);
        $participations = $this->getDoctrine()->getRepository(Participation::class)->findByConcour($id);
//        $pagination = $paginator->paginate($participations, $request->query->getInt('page', 1), 3);
        $user= $this->getDoctrine()->getRepository(User::class)->find($id);
        $scoresUser=$this->getDoctrine()->getRepository(Score::class)->FindByQuizId($id);
        usort($scoresUser,  array("App\Entity\Score", "compareScores"));
        $ranks = $this->getDoctrine()->getRepository(Participation::class)->findRanks($id);

        $res = new ArrayCollection();
        foreach ($ranks as $r) {
            $vid = $this->getDoctrine()->getRepository(video::class)->findById($r['video_id']);

            $res->add($vid);

        }

        return ($this->render('concour/concourVlist.html.twig', array('concour' => $concour, 'participations' => $participations,
            'ranks' => $res,'user'=>$user, 'scores' => array_slice($scoresUser, 0, 3) ))
        );
    }



    /**
     * @Route("/vote/{id}", name="concour_vote")
     *
     */
    public function voteAction($id)
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $user = $this->getUser();
        $user=$this->getDoctrine()->getRepository(User::class)->find('4');
        $video = $this->getDoctrine()->getRepository(Video::class)->find($id);
        $video->getVotes()->add($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();
      return new Response();
      return $this->redirectToRoute('concour_vote');

    }

    /**
     * @Route("/DownVote/{id}", name="concour_downVote")
     *
     */
    public function downVoteAction($id)
    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $user = $this->getUser();
        $user=$this->getDoctrine()->getRepository(User::class)->find('4');

        $video = $this->getDoctrine()->getRepository(video::class)->find($id);
        $video->getVotes()->removeElement($user);
        $em = $this->getDoctrine()->getManager();
        $em->persist($video);
        $em->flush();
        return new Response();

    }

    /**
     * @Route("/rankingV/{id}", name="update_ranks")
     * @param concour $id
     * @return Response
     */
    public function updateRanksAction($id)
    {

        $participations = $this->getDoctrine()->getRepository(Participation::class)->findByConcour($id);

        $ranks = $this->getDoctrine()->getRepository(Participation::class)->findRanks($id);

        $res = new ArrayCollection();
        foreach ($ranks as $r) {
            $vid = $this->getDoctrine()->getRepository(Video::class)->findById($r['video_id']);

            $res->add($vid);

        }

        return ($this->render('pages/ranksV.html.twig', ['ranks' => $res]
        ));
    }
    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("rechercheConcour", name="rechercheConcour")
     */

    public function rechercheConcour(Request $request, NormalizerInterface $normalizer){

        $repository = $this->getDoctrine()->getRepository(Concour::class);
        $requestString=$request->get('searchValue');

        $concour = $repository->findConcourByNom($requestString);

        return $this->render("concour/list.html.twig",
            ['concour'=>$concour]);
    }
//    /**
//     * @param Request $request
//     * @param NormalizerInterface $normalizer
//     * @return Response
//     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
//     * @Route("searchTopic", name="search")
//     */
//
//    public function searchTopic(Request $request, NormalizerInterface $normalizer){
//        $repository = $this->getDoctrine()->getRepository(Topics::class);
//        $requestString=$request->get('searchValue');
//
//        $topics = $repository->findTopicsByTitre($requestString);
//
//        return $this->render("topic/ajax.html.twig",
//            ['topics'=>$topics]);
//    }



//
//    /**
//     * Deletes a competition entity.
//     *
//     * @Route("/competition/participation/delete/{id}", name="participation_delete")
//     * @Method("DELETE")
//     * @param Request $request
//     * @param competition_participant $id
//     * @return Response
//     */
//    public function participationDeleteAction(Request $request, competition_participant $id)
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $participation = $this->getDoctrine()->getRepository(competition_participant::class)->find($id);
//        $video = $participation->getVideo();
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->remove($participation);
//        $entityManager->remove($video);
//        $entityManager->flush();
//
//        $response = new Response();
//        $response->send();
//
//        return $this->redirectToRoute('competition_show', ['id' => $participation->getcompetition()->getid()]);
//    }
//
//    /**
//     * Displays a form to edit an existing competition entity.
//     *
//     * @Route("/participation/{id}", name="participation_edit")
//     * @Method({"GET", "POST"})
//     * @param Request $request
//     * @param competition_participant $id
//     * @return RedirectResponse|Response
//     */
//    public function participationEditAction(Request $request, competition_participant $id)
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//        $participation = new competition_participant();
//        $participation = $this->getDoctrine()->getRepository(competition_participant::class)->find($id);
//        $video = $participation->getVideo();
//        $editForm = $this->createForm('CompetitionsBundle\Form\videoType', $video);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $this->getDoctrine()->getManager()->flush();
//
//            return $this->redirectToRoute('competition_show', ['id' => $participation->getcompetition()->getid()]);
//        }
//
//        return $this->render('CompetitionsBundle:Default:participation_edit.html.twig', array(
//
//            'form' => $editForm->createView(), 'participation' => $participation
//
//        ));
//    }
}
