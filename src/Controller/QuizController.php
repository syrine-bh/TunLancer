<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Entity\Score;
use App\Entity\Stars;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Message;
use App\Form\QuizType;
use App\Repository\ConcoursRepository;
use App\Repository\QuizRepository;
use App\Repository\ReponsetabRepository;
use App\Repository\ScoreRepository;
use AppBundle\Entity\competition;
use AppBundle\Entity\competition_participant;
use AppBundle\Entity\video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;


class QuizController extends AbstractController implements \ArrayAccess
{
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;

    }

    public function findScore($post)
    {
        if (isset($post)) {
            $score = 0;
            $nbrQuestion = count($post) - 1;
            dump($nbrQuestion);
            foreach ($post as $key => $value) {
                if ($key != "pseudo") {
                    $Reponses = $this->repReponse->find($value);
                    $reponseStatu = $Reponses->getStatu();
                    if ($reponseStatu) {
                        $score++;
                    }
                }


            }

            $scoreFinale = $score . "/" . $nbrQuestion;
        }
        return $scoreFinale;

    }

    public function __construct(QuizRepository $repQuiz, EntityManagerInterface $em, ScoreRepository $repScore,
                                ReponsetabRepository $repReponse, ConcoursRepository $repConcour)
    {
        $this->repQuiz = $repQuiz;
        $this->em = $em;
        $this->repScore = $repScore;
        $this->repReponse = $repReponse;
        $this->repConcour = $repConcour;
    }


    /**
     * @Route("/quiz", name="quiz")
     */
    public function index()
    {
        $quiz = $this->repQuiz->findAll();
        return $this->render('quiz/index.html.twig', ['quiz' => $quiz]);
    }


    /**
     * @Route ("/scoreQ/{id}",name="scoreQ")
     */
    public function scoreQ($id,Request $request,PaginatorInterface $paginator)
    {
        $quiz = $this->repQuiz->findQuiz($id);

        $donnees = $this->repScore->FindByQuizId($id);//recuperation des score de chaque quiz
        usort($donnees, array("App\Entity\Score", "compareScores"));
        $rank = array_slice($donnees, 0, 3);
        $scoresUser= $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6);
        return $this->render('pages/score.html.twig', ['scores' => $scoresUser, 'quiz' => $quiz, 'rank' => $rank]);

    }

    /**
     * @Route("/score", name="score")
     */
    public function score()
    {
        $scoresUser = $this->repScore->findAll();//recuperation des scores

        return $this->render('pages/score.html.twig', ['scores' => $scoresUser]);
    }


    /**
     * @Route("/result/{id}", name="result")
     * @param $id
     * @param $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function result($id)
    {
        /*
         si le formulaire n'est pas soumit ou si on accès d'accedé a la vue result
        par url, une redirection est encrenché vers la page d'acceuile.
         */
        if (!isset($_POST['pseudo'])) {
            return $this->redirectToRoute('participerConcours');
        } else {
            $score = $this->findScore($_POST);// on appelle fontions  traitement post =>score
            $em = $this->getDoctrine()->getManager();//initialisation atity manager de doctrine
            $pseudo = $this->repScore->findOneBy(array('pseudo' => $_POST['pseudo']));//essai recupération pseudo de l'entité score = post['pseudo']
            $quizid = $this->repScore->findOneBy(array('quiz' => $id));//essai recupération pseudo de l'entité score = post['pseudo']

            $quiz = $em->getRepository(Quiz::class)->find($id);
            if ($quizid != $id) { //false! enregistrer le  pseudo et le score dans la base
                $repScore = new Score();
                $repScore->setPseudo($_POST['pseudo'])
                    ->setScore($score)->setQuiz($quiz);
                $em = $this->getDoctrine()->getManager();
                $em->persist($repScore);
                $em->flush();
            } else {
                //true! mettre a jour le score du pseudo
                $pseudo->setScore($score)->setQuiz($quiz);
                $em->flush();
            }

            //envoie du score a la vue
            return $this->render('pages/result.html.twig', ['score' => $score
                , 'quiz' => $id
            ]);
        }


    }

    /**
     * @return Response
     * @Route("/ranking/{id}", name="ranks")
     */
    public function ranking($id)
    {
        $scoresUser = $this->repScore->FindByQuizId($id);
        $rank = usort($scoresUser, array("App\Entity\Score", "compareScores"));

        return ($this->render('pages/ranks.html.twig', array('scores' => array_slice($scoresUser, 0, 3),
            'rank' => $rank)));
    }



}
