<?php

namespace App\Controller;

use App\Entity\PostDislike;
use App\Entity\Replies;
use App\Entity\Topics;
use App\Entity\PostLike;
use App\Entity\Utilisateurs;
use App\Form\RepliesType;
use App\Form\RepliesUpdateType;
use App\Repository\PostDislikeRepository;
use App\Repository\PostLikeRepository;
use Doctrine\Persistence\ObjectManager;
use http\Message;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class RepliesController extends AbstractController
{
    /**
     * @Route("/replies", name="replies")
     */
    public function index(): Response
    {
        return $this->render('replies/index.html.twig', [
            'controller_name' => 'RepliesController',
        ]);
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/replies/showcomment", name="showcomment")
     */
    public function show(Request $request, PaginatorInterface $paginator){
        $replies = $this->getDoctrine()->getManager()->getRepository(Replies::class)->findAll();

        $data = $this->getDoctrine()->getRepository(Topics::class)->findBy([],
            ['date'=>'desc']);
        $topics= $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 3
        );
//        $topics = $this->getDoctrine()->getManager()->getRepository(Topics::class)->findAll();
        return $this->render('replies/listComment.html.twig',[
            "replies" => $replies,
            "topics"=>$topics
        ]);
    }
//
//    public function addComment(int $id, Request $request){
//        $reply= new Replies();
//        $em=$this->getDoctrine()->getManager();
//        $topic = $em->getRepository(Topics::class)->find($id);
//        $reply->setTopic($topic);
//        $reply->setCreatedAt(new \DateTime());
//        $form = $this->createForm(RepliesType::class, $reply);
//        $entitymanager = $this->getDoctrine()->getManager();
//        $form->handleRequest($request);
//            if ($form->isSubmitted() && $form->isValid()) {
//                $topic->addReply($reply);
//                $entitymanager->persist($reply);
//                $entitymanager->flush();
//
//
//            }
//
//
//
//
//
//    }
//
//


    /**
     * @param $id
     * @param Request $request
     * @return void
     *
     * @Route("/replies/showcomment/{id}", name="deletecommentaire")
     */
    public function deleteComment($id, Request $request){
        $em = $this ->getDoctrine()->getManager();
        $reply= $em->getRepository(Replies::class)->find($id);
        $em->remove($reply);
        $em->flush();
//        $response = new Response();
//        $response->send();
      return $this->redirectToRoute("showcomment");

    }

    /**
     * @param $id
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("replies/updatecomment/{id}", name="updatecomment")
     */
    public function updateComment($id,  Request $request){
        $em=$this->getDoctrine()->getManager();
        $reply= $em->getRepository(Replies::class)->find($id);
        $form=$this->createForm(RepliesUpdateType::class, $reply);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em->flush();
            return $this->redirectToRoute("showcomment");
        }
        return $this->render('replies/updatecomment.html.twig', array(
            'form'=>$form->createView()
        ));

    }




//    /**
//     * @Route("/replies/add", name="addComment")
//     */
//    public function add(Request $request)
//    {
//        $reply = new Replies();
//        $form = $this->createForm(RepliesType::class, $reply);
//
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($reply);
//            $em->flush();
//            return $this->redirectToRoute('showcomment');
//        }
//        return $this->render('replies/addcomment.html.twig', [
//            'form' => $form->createView()]);
//
//
//    }

    /**
     * liker
     * @Route("/commentaire/{id}/like", name="post_like")
     * @param $id
     * @param PostLikeRepository $likeRepository
     * @return Response
     */
    public function like($id, PostLikeRepository $likeRepository) : Response{
        $em = $this->getDoctrine()->getManager();
        $replies=$em->getRepository(Replies::class)->find($id);
        $user=$em->getRepository(Utilisateurs::class)->find(1);
        $find=false;
        $likes=$replies->getLikes();
        foreach ($likes as $like){
            if ($like->getUser()->getId()==$user->getId()){
                $find=true;
            }
        }
        if ($find==true){
            return new JsonResponse("vous avez déjà aimé");
        }else {
            $like = new PostLike();
            $like->setReply($replies);
            $like->setUser($user);
            $em->persist($like);
            $em->flush();

//        return new JsonResponse("like added");
            return $this->redirectToRoute('showcomment');
        }
    }

    /**
     * @param $id
     * @return Response
     * @Route("commentaire/removelike/{id}", name="remove_like")
     */
    public function removeLike(int $id) {
        $em=$this->getDoctrine()->getManager();
        $replies= $em->getRepository(Replies::class)->find($id);
        $user=$em->getRepository(Utilisateurs::class)->find(1);
//        $like=$em->getRepository(PostLike::class)->find($id);
        $likes=$replies->getLikes();
        foreach ($likes as $like){
            if (($like->getUser()->getId()==$user->getId()) && ($replies->getId()==$id))
                $em->remove($like);
                $em->flush();
        }
//        $em->remove($like);
//        $em->flush();
        return $this->redirectToRoute('showcomment');
    }

    /**
     * @Route("/commentaire/{id}/dislike", name="post_dislike")
     * @param $id
     * @param PostDislikeRepository $dislikeRepository
     * @return Response
     *
     */
    public function dislike($id, PostDislikeRepository $dislikeRepository): Response{
        $em=$this->getDoctrine()->getManager();
        $replies = $em->getRepository(Replies::class)->find($id);
        $dislike = new PostDislike();
        $dislike->setReply($replies);
        $em->persist($dislike);
        $em->flush();
        return $this->redirectToRoute('showcomment');
    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("commentaire/removedislike/{id}", name="remove_dislike")
     */
    public function removeDislike(int $id){
        $em = $this->getDoctrine()->getManager();
        $dislike = $em->getRepository(PostDislike::class)->find($id);
        $em->remove($dislike);
        $em->flush();
        return $this->redirectToRoute('showcomment');

    }





}
