<?php

namespace App\Controller;


use App\Entity\Replies;
use App\Entity\Topics;
use App\Form\RepliesType;
use App\Form\TopicsType;
use App\Form\UpdateTopicType;
use App\Repository\TopicsRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use http\Exception\InvalidArgumentException;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizableInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\DateTime;



class TopicController extends AbstractController
{

    /**
     * @Route("/topic", name="topic")
     */
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        $donnes = $this->getDoctrine()->getRepository(Topics::class)->findBy([],
        ['date'=>'desc']);
        $topics = $paginator->paginate(
            $donnes,
            $request->query->getInt('page', 1), 3
        );
        return $this->render('topic/index.html.twig', [
            'topics'=>$topics,

        ]);
    }

    /**
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return Response
     * @Route("/topic/list", name="showtopic")
     */
    public function show(Request $request, PaginatorInterface $paginator): Response {
        $data = $this->getDoctrine()->getRepository(Topics::class)->findAll();
        $topics = $paginator->paginate(
            $data,
            $request->query->getInt('page', 1), 3
        );
        return $this->render('topic/listTopic.html.twig',[
            "topics" => $topics,
        ]);
    }

    /**
     * @return Response
     * @Route("/topic/grille", name="showgrille")
     */
    public function showTopic(Request $request, PaginatorInterface $paginator): Response {
        $topics = $this->getDoctrine()->getManager()->getRepository(Topics::class)->findAll();
        return $this->render('topic/grilleTopic.html.twig',[
            "topics" => $topics,
        ]);
    }

    /**
     * @return Response
     * @Route("/topic/listback", name="listback")
     */
    public function showBack(){
        $topics = $this->getDoctrine()->getManager()->getRepository(Topics::class)->findAll();
        return $this->render('topic/listTopicBack.html.twig',[
            "topics" => $topics,
        ]);
    }


    /**
     * @Route("/topic/add", name="addTopic")
     */
    public function add(Request $request){
        $topics = new Topics();
        $topics->setDislikes(0);
        $topics->setLikes(0);
        $topics->setViews(0);
        $topics->setDate(New \DateTime());
        $form = $this->createForm(TopicsType::class, $topics);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($topics);
            $em->flush();
            return $this->redirectToRoute('showtopic');
        }
        return $this->render('topic/addTopic.html.twig',
            ['form'=>$form->createView()]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @Route("/topic/updateTopic/{id}", name="updateTopic")
     */
    public function update($id,Request $request){
        $em = $this->getDoctrine()->getManager();
        $topics = $em->getRepository(Topics::class)->find($id);
        $form = $this->createForm(UpdateTopicType::class, $topics);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            return $this->redirectToRoute('topic');
        }
        return $this->render("topic/updateTopic.html.twig",
            ['form'=>$form->createView()]);

    }

    /**
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route("/topic/delete/{id}", name="deleteTopic")
     */
    public function delete(int $id){
        $entityManager = $this->getDoctrine()->getManager();
        $topics= $entityManager->getRepository(Topics::class)->find($id);
        $entityManager->remove($topics);
        $entityManager->flush();
        return $this->redirectToRoute("showtopic");

    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/topic/details/{id}", name="details")
     */
    public function details($id,  Request $request){
        $entitymanager = $this->getDoctrine()->getManager();
        /*$topics = $entitymanager->getRepository(Topics::class)->findAll();*/
        $topics = $entitymanager->getRepository(Topics::class)->find($id);

        $entitymanager ->flush();
        $reply = new Replies();
        $replies = $entitymanager->getRepository(Replies::class)->findAll();
        $reply->setCreatedAt(new \DateTime());
        //$reply->setTopic($topics);
        $form = $this->createForm(RepliesType::class, $reply);
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            //$topics->addReply($reply);
            $reply->setTopic($topics);
            $em = $this->getDoctrine()->getManager();
            $em->persist($reply);
            $em->flush();
            return $this->redirectToRoute('showcomment');
        }

        return $this->render('topic/details.html.twig', [
            'topics'=>$topics,
            'form'=>$form->createView(),
            'replies'=>$replies

        ]);

    }

    /**
     * @param Request $request
     * @param NormalizerInterface $normalizer
     * @return Response
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     * @Route("searchTopic", name="search")
     */

    public function searchTopic(Request $request, NormalizerInterface $normalizer){
        $repository = $this->getDoctrine()->getRepository(Topics::class);
        $requestString=$request->get('searchValue');

        $topics = $repository->findTopicsByTitre($requestString);

        return $this->render("topic/ajax.html.twig",
            ['topics'=>$topics]);
    }



//
//    /**
//     * @param int $id
//     * @param Request $request
//     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
//     * @Route("topic/addcomment/{id}", name="addcomment")
//     */
//
//    public function addComment(int $id, Request $request){
//        $reply = new Replies();
//        $em=$this->getDoctrine()->getManager();
//        $topics = $em->getRepository(Topics::class)->find($id);
//
//        $reply->setTopic($topics);
//        $reply->setCreatedAt(New \DateTime());
//
//        $form=$this->createForm(RepliesType::class, $reply);
//        $form->handleRequest($request);
//        if ($form->isSubmitted() && $form->isValid()){
//            $topics->addReply($reply);
//            $em->persist($reply);
//            $em->flush();
//            return $this->redirectToRoute('showcomment');
//        }
//        return $this->render('topic/details.html.twig', [
//            'topics'=>$topics,
//            'form'=>$form->createView(),
//            'replies'=>$reply,
//        ]);
//
//    }













}
