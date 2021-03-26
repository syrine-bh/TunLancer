<?php

namespace App\Controller;
use App\Entity\Questiontab;
use App\Entity\Participation;
use App\Entity\Concour;
use App\Entity\Quiz;
use App\Entity\Reponsetab;
use App\Entity\Score;
use App\Repository\ConcoursRepository;
use App\Repository\QuestiontabRepository;
use App\Repository\QuizRepository;
use App\Repository\ReponsetabRepository;
use App\Repository\ScoreRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Response;
use ArrayAccess;
use Swift_Message;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;


class QuestionController extends Controller
{

  //cette fonction permet de calculer le score et de retourner le score

//    public function offsetSet($offset, $value) {
//        if (is_null($offset)) {
//            $this->container[] = $value;
//        } else {
//            $this->container[$offset] = $value;
//        }
//    }
//    public function offsetExists($offset) {
//        return isset($this->container[$offset]);
//    }
//    public function offsetUnset($offset) {
//        unset($this->container[$offset]);
//    }
//    public function offsetGet($offset) {
//        return isset($this->container[$offset]) ? $this->container[$offset] : null;
//    }
//    public function findScore($post){
//    if (isset($post)){
//        $score=0;
//        $nbrQuestion=count($post)-1;
//        dump($nbrQuestion);
//        foreach ($post as $key => $value){
//            if ($key!="pseudo"){
//                $Reponses=$this->repReponse->find($value);
//                $reponseStatu=$Reponses->getStatu();
//                if ($reponseStatu){
//                    $score++;
//                }
//            }
//
//
//        }
//
//        $scoreFinale=$score."/".$nbrQuestion;
//    }
//    return $scoreFinale;
//
//}

    /**
     * @var $repScore;
     * @var QuestionsRepository;
     * @var ReponsesRepository;
     */
    private $repQuestion;
    private $repReponse;
    private $repScore;
    public function __construct(QuestiontabRepository $repQuestion, ReponsetabRepository $repReponse,
                                ScoreRepository $repScore,QuizRepository $repQuiz,ConcoursRepository $repConcour)
    {
        $this->repQuestion=$repQuestion;
        $this->repReponse=$repReponse;
        $this->repScore=$repScore;
        $this->repQuiz=$repQuiz;
        $this->repConcour=$repConcour;
    }

    /**
     * @Route("/participer/{id}", name="participerConcours")
     */
    public function participerConcours()
    {
        $concour=$this->repConcour->findAll();
        return $this->render('pages/home.html.twig',['concour'=>$concour]);
    }


    /**
     * @Route("/question", name="question")
     */
    public function question()
    {
        $questions=$this->repQuestion->findAll();//recuperation de tout les questions

        return $this->render('pages/quiz.html.twig',['questions'=>$questions]);
    }

    /**
     * @Route ("/questionQ/{id}",name="questionQ")
     */
    public function questionQ($id){
        $questions=$this->repQuestion->FindByQuizId($id);//recuperation des questions de chaque quiz
        return $this->render('pages/quiz.html.twig',['questions'=>$questions]);

    }

//
//    /**
//     * @Route("/quizConcour{id}", name="quizConcour")
//     */
//    public function quizConcour($id)
//    {
//        $concour=$this->repConcour->findAll();
//      $questions=$this->repQuestion->FindByQuizId($id);
//        $quiz=$this->repQuiz->findAll();
//        return $this->render('pages/home.html.twig',['concour'=>$concour,
//            'quiz'=>$quiz]);
//    }







//    /**
//     * @Route("/quizHome{id}", name="quizHome")
//     */
//    public function quiz($id)
//    {   $repo=$this->getDoctrine()->getRepository(Concour::class);
//        $concour=$repo->findAll();
////        $questions=$this->repQuestion->FindByQuizId($id);
//        return $this->render('pages/home.html.twig',['questions'=>$questions,
//            'concour'=>$concour]);
//    }

//    /**
//     * @Route ("/question/{id}",name="quiz")
//     */
//    public function question(Concour $concour, QuestiontabRepository $rep){
//        $test=$rep->FindByConcId($concour->getId());
//        return $this->render('pages/quiz.html.twig',['questions'=>$test]);
//
//    }




//    /**
//     * @Route("/score", name="score")
//     */
//    public function score()
//    {
//        $scoresUser=$this->repScore->findAll();//recuperation des scores
//
//        return $this->render('pages/score.html.twig',['scores'=>$scoresUser]);
//    }
//    /**
//     * @Route("/result", name="result")
//     */
//    public function result()
//    {
//        /*
//         si le formulaire n'est pas soumit ou si on accès d'accedé a la vue result
//        par url, une redirection est encrenché vers la page d'acceuile.
//         */
//        if (!isset($_POST['pseudo'])){
//            return $this->redirectToRoute('home');
//        }else{
//            $score=$this->findScore($_POST);// on appelle fontions  traitement post =>score
//            $em=$this->getDoctrine()->getManager();//initialisation atity manager de doctrine
//            $pseudo=$this->repScore->findOneBy(array('pseudo'=>$_POST['pseudo']));//essai recupération pseudo de l'entité score = post['pseudo']
//            if (!$pseudo){ //false! enregistrer le  pseudo et le score dans la base
//                $repScore=new Score();
//                $repScore->setPseudo($_POST['pseudo'])
//                    ->setScore($score);
//                $em=$this->getDoctrine()->getManager();
//                $em->persist($repScore);
//                $em->flush();
//            }else{
//                //true! mettre a jour le score du pseudo
//                $pseudo->setScore($score);
//                $em->flush();
//            }
//            //envoie du score a la vue
//            return $this->render('pages/result.html.twig',['score'=>$score]);
//        }
//
//    }
//    /**
//     * @Route("/ranking", name="ranks_feed")
//
//     * @return Response
//     */
//    public function updateRanks()
//    {
//        $scoresUser=$this->repScore->findAll();
//        usort($scoresUser,  array("App\Entity\Score", "compareScores"));
//      return ($this->render('pages/ranks.html.twig', array('scores' => array_slice($scoresUser, 0, 3) )));
//    }

    /**
     * @Route("/promote/{id}", name="promote_user")
     * @param User $id
     * @return Response
     *
     */
    public function promote($id)
    {

        $genius = $this->getDoctrine()->getRepository(Score::class)->find($id);
        $message = (new Swift_Message('Congratulations Email'))
            ->setFrom('tunlancer.coders@gmail.com')
            ->setTo($genius->getEmail());
        $message->setBody(
            '<html>' .
            ' <body>' .
            '  <h1>Congrats </h1><br><img src="' .
            $message->embed(\Swift_Image::fromPath('D:\congrats.png')) .
            '" alt="Image" />' .
            ' <h1> Vous êtes parmis les tops 3 ranked dans le concours FELICITATIONS !</h1>' .
            ' </body>' .
            '</html>',
            'text/html');
        $this->get('mailer')->send($message);
        $em = $this->getDoctrine()->getManager();
        $em->persist($genius);
        $em->flush();
        return $this->redirectToRoute('adminHome');


    }



}
