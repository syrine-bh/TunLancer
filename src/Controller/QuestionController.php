<?php

namespace App\Controller;
use App\Entity\Questiontab;
use App\Entity\Participation;
use App\Entity\Concour;
use App\Entity\Quiz;
use App\Entity\Reponsetab;
use App\Entity\Score;
use App\Entity\User;
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
     * @Route("/notificationModification/{idConcour}/{idUser}", name="notificationModification")
     * @param User $id
     * @return Response
     *
     */
    public function notificationModification($idConcour, $idUser)
    {
        $em=$this->getDoctrine()->getManager();
        $concour=$this->repConcour->find($idConcour);
        $participant = $this->getDoctrine()->getRepository(Participation::class)->findByConcour($concour);
        $user=$em->getRepository(User::class)->find($idUser);

        $message = (new \Swift_Message('Update Email'))
            ->setFrom('tunlancer.coders@gmail.com')
            ->setTo($user->getEmail());
        $message->setBody(
            '<html>' .
            ' <body>' .
            '  <h1>Modification date concours</h1><br><img src="' .
            $message->embed(\Swift_Image::fromPath('D:\congrats.png')) .
            '" alt="Image" />' .
            ' Madame/Monsieur,' .
            'Nous vous prions de bien vouloir noter que la date de Concours à était modifiée' .

            ' </body>' .
            '</html>',
            'text/html');
        $this->get('mailer')->send($message);
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($participant);
//        $em->flush();
        return $this->redirectToRoute('listCadmin');
        return $this->render("admin/concour/notifMail.html.twig",[

            'idUser'=>$user,'participant'=>$participant]);

    }


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
        return $this->redirectToRoute('list');


    }
}
