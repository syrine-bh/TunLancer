<?php

namespace App\Controller;

use App\Entity\Concour;
use App\Entity\Participation;
use App\Entity\Questiontab;
use App\Entity\Quiz;
use App\Entity\Reponsetab;
use App\Entity\Score;
use App\Entity\Users;
use App\Entity\Video;
use App\Form\AddQuestionFormType;
use App\Form\ConcoursType;
use App\Form\ImageConcourType;
use App\Form\QuestionType;
use App\Form\QuizType;
use App\Form\ReponseFormType;
use App\Repository\ConcoursRepository;
use App\Repository\ParticipationRepository;
use App\Repository\QuestiontabRepository;
use App\Repository\QuizRepository;
use App\Repository\ReponsetabRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use App\Repository\ScoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

class AdminController extends AbstractController
{
    /**
     * @var $repScore ;
     * @var QuestionsRepository;
     * @var ReponsesRepository;
     */
    private $repQuestion;
    private $repReponse;
    private $repScore;
    private $em;

    public function __construct(QuestiontabRepository $repQuestion, ReponsetabRepository $repReponse,
                                ScoreRepository $repScore, EntityManagerInterface $em,
                                QuizRepository $repQuiz, ConcoursRepository $repConcour)
    {
        $this->repQuestion = $repQuestion;
        $this->repReponse = $repReponse;
        $this->repScore = $repScore;
        $this->repQuiz = $repQuiz;
        $this->repConcour = $repConcour;
        $this->em = $em;
    }

//    /**
//     * @Route("/admin", name="admin")
//     */
//    public function index(): Response
//    {
//        return $this->render('baseBack.html.twig'
//            , [
//            'controller_name' => 'AdminController',
//        ]
//        );
//    }

    /**
     * @Route("/adminHome", name="adminHome")
     */
    public function index(): Response
    {
        return $this->render('baseBack.html.twig'
            , [
                'controller_name' => 'AdminController',
            ]
        );
    }

    /**
     * @return Response
     * @Route ("/listCadmin",name="listCadmin")
     */
    public function listCadmin()
    {
        $repo = $this->getDoctrine()->getRepository(Concour::class);
        $concours = $repo->findAll();
        return $this->render('admin/concour/listCadmin.html.twig', ['concour' => $concours]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("concour/ajoutCadmin",name="ajoutCadmin")
     */
    public function ajoutConcours(Request $request)
    {
        $concours = new Concour();
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('imageName')->getData();
            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $concours->setImageName($fichier);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($concours);
            $em->flush();
            return $this->redirectToRoute('listCadmin');
        }
        return $this->render("admin/concour/ajouterConcours.html.twig", [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route ("concour/modifierConcours{id}",name="modifierConcours")
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifier($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Concour::class);
        $concours = $repo->find($id);
        $form = $this->createForm(ConcoursType::class, $concours);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les images transmises
            $images = $form->get('imageName')->getData();
            // On boucle sur les images
            foreach ($images as $image) {
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $concours->setImageName($fichier);
            }
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('notification', ['idConcour' => $id]);
        }
        return $this->render("admin/concour/modifierConcours.html.twig", [
            'form' => $form->createView(),
            'concour' => $concours
        ]);
    }


    /**
     * @return Response
     * @Route ("/supprimerConcours/{id}",name="supprimerConcours")
     */
    public function deleteConcours($id)
    {
        $em = $this->getDoctrine()->getManager();
        $concours = $em->getRepository(Concour::class)->find($id);
        $em->remove($concours);
        $em->flush();
        return $this->redirectToRoute('listCadmin');

    }

    /**
     * @Route("/admin/listQuiz", name="listQuiz")
     */
    //liste des quizz
    public function listQuiz()
    {
        $quiz = $this->repQuiz->findAll();
        return $this->render('admin/quiz/listQuiz.html.twig', ['quiz' => $quiz]);
    }

    /**
     * @Route("/listQuestions/{id}", name="listQuestions")
     */
    public function listQuestions($id)
    {
        $questions = $this->repQuestion->FindByQuizId($id);//recuperation de tout les questions

        return $this->render('admin/quiz/listQuestions.html.twig', ['questions' => $questions]);
    }

    /**
     * @Route("/listReponses/{id}", name="listReponses")
     */
    public function listReponses($id)
    {
        $reponses = $this->repReponse->findByQuestionId($id);//recuperation de tout les reponses

        return $this->render('admin/quiz/listReponses.html.twig', ['reponses' => $reponses]);
    }


    /**
     * @Route("/admin/addQuestion/{id}", name="addQuestion")
     */
    public function addQuestion(Request $request)
    {
        $questiontab = new Questiontab();
        $form = $this->createForm(AddQuestionFormType::class, $questiontab);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {

            $this->em->persist($questiontab);
            $this->em->flush();
            $idQuiz = $questiontab->getQuiz()->getId();
            return $this->redirectToRoute('listQuiz', ['id' => $idQuiz]);
        } else {
            return $this->render('admin/quiz/addQuestion.html.twig', ['form' => $form->createView()]);
        }
    }


    /**
     * @Route("/modifierQuestion/{idQuiz}/{idQuestion}", name="modifierQuestion")
     */
    public function modifierQuestion($idQuiz, $idQuestion, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository(Questiontab::class)->find($idQuestion);
        $Form = $this->createForm(QuestionType::class, $questions);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('listQuestions', ['id' => $idQuiz]);
        }
        return $this->render('admin/quiz/modifierQuestion.html.twig', [
            'questions' => $questions,
            'form' => $Form->createView()]);
    }


    /**
     * @Route("/admin/supprimerQuestion/{idQuiz}/{idQuestion}", name="supprimerQuestion")
     */
    public function supprimerQuestion($idQuiz, $idQuestion)
    {
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository(Questiontab::class)->find($idQuestion);
        $em->remove($questions);
        $em->flush();
        return $this->redirectToRoute('listQuestions', ['id' => $idQuiz]);
    }


    /**
     * @Route("/admin/addReponse/{id}", name="addReponse")
     */
    public function addreponse(Questiontab $question, Request $request, $id)
    {
        $reponsetab = new Reponsetab();
        $form = $this->createForm(ReponseFormType::class, $reponsetab);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $reponsetab->setQuestion($question);
            $this->em->persist($reponsetab);
            $this->em->flush();
            return $this->redirectToRoute('listReponses', ['id' => $id]);
        }

        return $this->render('admin/quiz/addReponse.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/editReponse/{idQuestion}/{idReponse}", name="editReponse")
     */
    public function modifierReponse($idQuestion, $idReponse, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $reponses = $em->getRepository(Reponsetab::class)->find($idReponse);
        $Form = $this->createForm(ReponseFormType::class, $reponses);
        $Form->handleRequest($request);
        if ($Form->isSubmitted()) {
            $em->flush();
            return $this->redirectToRoute('listReponses', ['id' => $idQuestion]);
        }
        return $this->render('admin/quiz/editreponse.html.twig', [
            'reponses' => $reponses,
            'form' => $Form->createView()]);
    }


    /**
     * @Route("/admin/supprimerReponse/{idQuestion}/{idReponse}", name="supprimerReponse")
     */
    public function supprimerReponse($idQuestion, $idReponse)
    {
        $em = $this->getDoctrine()->getManager();
        $reponse = $em->getRepository(Reponsetab::class)->find($idReponse);
        $em->remove($reponse);
        $em->flush();
        return $this->redirectToRoute('listReponses', ['id' => $idQuestion]);
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("admin/ajoutQuiz",name="ajoutQuiz")
     */
    public function ajoutQuiz(Request $request)
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute('listQuiz');
        }
        return $this->render('admin/quiz/ajoutQuiz.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route ("admin/modifierQuiz{id}",name="modifierQuiz")
     * @param $id
     * @param $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    function modifierQuiz($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $repo->find($id);
        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('listQuiz');
        }
        return $this->render("admin/quiz/modifierQuiz.html.twig", [
            'form' => $form->createView(),
            'quiz' => $quiz
        ]);
    }

    /**
     * @Route("/admin/supprimerQuiz{id}", name="supprimerQuiz")
     */
    public function supprimerQuiz($id)
    {
        $repo = $this->getDoctrine()->getRepository(Quiz::class);
        $quiz = $repo->find($id);

        $this->em->remove($quiz);
        $this->em->flush();
        return $this->redirectToRoute('listQuiz', ['quiz' => $quiz]);
    }
//Jarb aamel boucle
//fel fonction mtaa el controller
//getbyid lel concours eli taamlou fi modifications
//mbaaed trecuperi el liste participants
//mbaaed taamel el boucle
    /**
     * @Route("/notification/{idConcour}", name="notification")
     */
    public function notification($idConcour)
    {

        $participant = $this->getDoctrine()->getRepository(Participation::class)
            ->FindByConcId($idConcour);


        return $this->render("admin/concour/notifMail.html.twig", [

            'participant' => $participant]);

    }

    /**
     * @Route("/statsCP", name="statsCP")
     */
    public function statsCP(ConcoursRepository $repConcour, ParticipationRepository $repPart)
    {
        $concours = $repConcour->findAll();
        $concNom = [];
        $concColor = [];
        $concCount = [];
        foreach ($concours as $concour) {
            $concNom[] = $concour->getNom();
            $concColor[] = $concour->getCouleur();
            $concCount[] = count($concour->getParticipations());
        }

        $participations = $repPart->countByDate();
        $dates = [];
        $participationsCount = [];
        foreach ($participations as $participation) {
            $dates[] = $participation['dateParticipation'];
            $participationsCount[] = $participation['count'];
        }


        return $this->render('admin/concour/stats.html.twig', [
            'concNom' => json_encode($concNom),
            'concColor' => json_encode($concColor),
            'concCount' => json_encode($concCount),
            'dates' => json_encode($dates),
            'participationsCount' => json_encode($participationsCount),

        ]);
    }

    /**
     * @Route("/statsCQ", name="statsCQ")
     */
    public function statsCQ(QuizRepository $repQuiz)
    {
        $quiz = $repQuiz->findAll();
        $quizNom = [];
        $quizColor = [];
        $quizCount = [];
        foreach ($quiz as $quiz) {
            $quizNom[] = $quiz->getNom();
            $quizColor[] = $quiz->getCouleur();
            $quizCount[] = count($quiz->getScores());
        }

//        $participations = $repPart->countByDate();
//        $dates = [];
//        $participationsCount=[];
//        foreach ($participations as $participation){
//            $dates[]=$participation['dateParticipation'];
//            $participationsCount[]=$participation['count'];
//        }

        return $this->render('admin/quiz/stats.html.twig', [
            'quizNom' => json_encode($quizNom),
            'quizColor' => json_encode($quizColor),
            'quizCount' => json_encode($quizCount),
//            'dates' => json_encode($dates),
//            'participationsCount' => json_encode($participationsCount)
        ]);

    }

//
//    /**
//     * @Route("post/{id}", name="post")
//     * @param $id
//     * @return Response
//     */
//    public function postAction($id)
//    {
//        $post=$this->getDoctrine()->getRepository(Video::class)->find($id);
//        return ($this->render('default/post.html.twig',['post'=>$post])
//        );
//    }
        /**
         * @Route("feed/ranking/", name="ranks_feed")
         * @return Response
         */
        public
        function updateRanksAction()
        {
            $ranks = $this->getDoctrine()->getRepository(Video::class)->findRanks();

            $res = new ArrayCollection();
            foreach ($ranks as $r) {
                $vid = $this->getDoctrine()->getRepository(Video::class)->findById($r['video_id']);
                dump($vid);
                $res->add($vid);

            }
            dump($res);
            return ($this->render('pages/ranksV.html.twig', array('res' => $res))
            );
        }

    }

