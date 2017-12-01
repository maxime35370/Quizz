<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/10/2017
 * Time: 10:56
 */

namespace QuizzBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class QuizzController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction (){
        return $this->render('QuizzBundle:Quizz:quizzhome.html.twig');
    }


    /**
     * @Route("/question")
     */
    public function questionAction (){
        $em = $this->getDoctrine() -> getManager();
        /* @var $repositoryQuestion \QuizzBundle\Repository\QuestionRepository */
        $repositoryQuestion = $em->getRepository('QuizzBundle:Question');
        /* @var $repositoryReponse \QuizzBundle\Repository\ReponseRepository */
        $repositoryReponse =$em->getRepository('QuizzBundle:Reponse');
        /* @var $repositoryCategorie \QuizzBundle\Repository\CategorieRepository */
        $repositoryCategorie =$em->getRepository('QuizzBundle:Categorie');
        $idCategorie = $repositoryCategorie->findOneByLibelle('TestQuizzDemo');
        //var_dump($idCategorie);
        $listequestionDeLaCategorie = $repositoryQuestion->listeQuestionParCategorie($idCategorie);
        //var_dump($listequestionDeLaCategorie);
        $nbQuestion = sizeof($listequestionDeLaCategorie);
        //var_dump($nbQuestion);
        //var_dump($nbQuestion);

        foreach ($listequestionDeLaCategorie as $question)
        {
            $idQuestion = $question->getId();
            $libelleQuestion = $question->getLibelle();
            //var_dump($idQuestion .' '.$libelleQuestion  );
            $listeReponseDeLaQuestion = $repositoryReponse->listeReponseParQuestion($idQuestion);
            $nbRep = sizeof($listeReponseDeLaQuestion);
            //var_dump($nbRep);

            foreach ($listeReponseDeLaQuestion as $reponse)
            {
                //var_dump($listeReponseDeLaQuestion);
                $idRep = $reponse->getId();
                $libelleRep = $reponse->getLibelle();
                //var_dump($idRep.' '.$libelleRep);
                $tableauReponses[] = $reponse;
            }
        }

        $premiereQuestionDeLaCategorie = $repositoryQuestion->PremiereQuestionDeLaCategorie($idCategorie);
        //var_dump($premiereQuestionDeLaCategorie);

        $derniereQuestionDeLaCategorie = $repositoryQuestion->DerniereQuestionDeLaCategorie($idCategorie);
        //var_dump($derniereQuestionDeLaCategorie );
        //setcookie('idPremiereQuestionQuizz',$premiereQuestionDeLaCategorie,0,"/","",0);
        //var_dump($tableauReponses);

        if($listequestionDeLaCategorie!=null && $listeReponseDeLaQuestion!=null){
            return $this->render('QuizzBundle:Quizz:question.html.twig',[
                'question'=>$listequestionDeLaCategorie,
                'listeReponse'=>$tableauReponses,
                'premiereQuestionDeLaCategorie'=>$premiereQuestionDeLaCategorie,
                'derniereQuestionDeLaCategorie'=>$derniereQuestionDeLaCategorie
            ]);
        }

        return $this->render('QuizzBundle:Resultat:resultat.html.twig');

    }
}