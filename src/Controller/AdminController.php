<?php

namespace App\Controller;
use App\Entity\Questiontab;
use App\Entity\Quiz;
use App\Entity\Reponsetab;
use App\Form\AddQuestionFormType;
use App\Form\QuizType;
use App\Form\ReponseFormType;
use App\Repository\QuestiontabRepository;
use App\Repository\ReponsetabRepository;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
class AdminController extends Controller
{
    /**
     * @var $repScore;
     * @var QuestionsRepository;
     * @var ReponsesRepository;
     */
    private $repQuestion;
    private $repReponse;
    private $repScore;
    private $em;

    public function __construct(QuestiontabRepository $repQuestion, ReponsetabRepository $repReponse, ScoreRepository $repScore, EntityManagerInterface $em)
    {
        $this->repQuestion=$repQuestion;
        $this->repReponse=$repReponse;
        $this->repScore=$repScore;
        $this->em=$em;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        $questions=$this->repQuestion->findAll();
        return $this->render('admin/index.html.twig',['questions'=>$questions]);
    }
    /**
     * @Route("/admin/edit{id}", name="edit")
     */
    public function edit(Questiontab $questions, Request $request,$id)
    {
        $form=$this->createForm(AddQuestionFormType::class,$questions);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $this->em->flush();
        }
        return $this->render('admin/edit.html.twig',[
            'questions'=>$questions,
            'form'=>$form->createView()]);
    }
    /**
     * @Route("/admin/delete{id}", name="delete")
     */
    public function delet($id)
    {
        $question=$this->repQuestion->find($id);
        $this->em->remove($question);
        $this->em->flush();
        $questions=$this->repQuestion->findAll();
        return $this->redirectToRoute('admin',['questions'=>$questions]);
    }
    /**
     * @Route("/admin/addQuestion", name="addQuestion")
     */
    public function add(Request $request)
    {
        $questiontab=new Questiontab();
        $form=$this->createForm(AddQuestionFormType::class,$questiontab);
        $form->handleRequest($request);
        if ($form-> isSubmitted()){

            $this->em->persist($questiontab);
            $this->em->flush();
            $idQuestion=$questiontab->getId();
            return $this->redirectToRoute('addReponse',['id'=>$idQuestion]);
        }else{
            return $this->render('admin/add.html.twig',['form'=>$form->createView()]);
        }
    }

    /**
     * @Route("/admin/addReponse{id}", name="addReponse")
     */
    public function addreponse(Questiontab $question ,Request $request, $id)
    {
        $reponsetab=new Reponsetab();
        $form=$this->createForm(ReponseFormType::class, $reponsetab);
        $form->handleRequest($request);
        if ($form-> isSubmitted()){
            $reponsetab->setQuestion($question);
            $this->em->persist($reponsetab);
            $this->em->flush();
        }

        return $this->render('admin/addReponse.html.twig',['form'=>$form->createView()]);
    }
    /**
     * @Route("/editReponse{id}", name="editReponse")
     */
    public function editReponse(Reponsetab $reponses,$id, Request $request)
    {
        $form=$this->createForm(ReponseFormType::class,$reponses);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            $this->em->flush();
        }
        return $this->render('admin/editreponse.html.twig',[
            'reponses'=>$reponses,
            'form'=>$form->createView()]);
    }



    /**
     * @param Request $request
     * @return Response
     * @Route ("admin/ajoutQuiz",name="ajoutQuiz")
     */
    public function ajoutQuiz (Request $request){
        $quiz=new Quiz();
        $form=$this->createForm(QuizType::class,$quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute('quiz');
        }
        return $this->render('admin/ajoutQuiz.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route ("admin/modifierQuiz{id}",name="modifierQuiz")
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier($id,Request $request){
        $repo=$this->getDoctrine()->getRepository(Quiz::class);
        $quiz=$repo->find($id);
        $form=$this->createForm(QuizType::class,$quiz);
//        $form->add('Modifier',SubmitType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()&& $form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('quiz');
        }
        return $this->render("quiz/modifierQuiz.html.twig",[
            'form'=>$form->createView(),
            'quiz'=>$quiz
        ]);
    }
    /**
     * @Route("/admin/supprimerQuiz{id}", name="supprimerQuiz")
     */
    public function supprimerQuiz($id)
    {
        $repo=$this->getDoctrine()->getRepository(Quiz::class);
        $quiz=$repo->find($id);

        $this->em->remove($quiz);
        $this->em->flush();
        return $this->redirectToRoute('quiz',['quiz'=>$quiz]);
    }


















}
