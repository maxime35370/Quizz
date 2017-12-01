<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03/11/2017
 * Time: 10:08
 */

namespace QuizzBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Validator\Constraints\DateTime;

class TestController extends Controller
{
    /**
     * @Route("/test")
     */
    public function AccesTestAction(){
        return $this->render('QuizzBundle:Test:testhome.html.twig');
    }

    /**
     * @Route("/test/explication")
     */
    public function ExplicationTestAction()
    {
        $em = $this->getDoctrine()->getManager();
        /* @var $repositoryTest \QuizzBundle\Repository\TestRepository */
        $repositoryTest = $em->getRepository('QuizzBundle:Test');
        if (isset($_COOKIE['idTestEnCours'])) {
            $test = $repositoryTest->findById($_COOKIE['idTestEnCours']);
            foreach ($test as $leTest) {
                $nomTest = $leTest->getLibelle();
            }
            /* @var $repositoryQuestion \QuizzBundle\Repository\QuestionRepository */
            $repositoryQuestion = $em->getRepository('QuizzBundle:Question');
            $nbQuestionDuTest = $repositoryQuestion->NbDeQuestionDuTest($_COOKIE['idTestEnCours']);
            $nbQuestionDuTestEnCours = $nbQuestionDuTest;

            /* @var $repositoryCategorie \QuizzBundle\Repository\CategorieRepository */
            $repositoryCategorie = $em->getRepository('QuizzBundle:Categorie');
            $nbCategorieDuTest = $repositoryCategorie->NbCategorieDuTest($_COOKIE['idTestEnCours']);
            $nbCategorieDuTestEnCours = $nbCategorieDuTest;

            $premiereCategorieDuTest = $repositoryCategorie->PremiereCategorieDuTest($_COOKIE['idTestEnCours']);
            foreach($premiereCategorieDuTest as $premCatDuTest){
                $idPremiereCategorie = $premCatDuTest->getId();
            }
            //setcookie('idPremiereCategorie',$idPremiereCategorie,time()+3600,"/","",0);
        }
        return $this->render('QuizzBundle:Test:testexplication.html.twig',[
            'nomTest'=>$nomTest,
            'nbQuestionDuTest'=>$nbQuestionDuTestEnCours,
            'nbCategorieTest'=>$nbCategorieDuTestEnCours
        ]);
    }


    /**
     * @Route("test/listeTest")
     */
    public function listeTest (){

        $em = $this->getDoctrine() -> getManager();

        //Reinisialisation des cookie IdTestEnCours , IdCategorieEnCours et XV
        if (isset($_COOKIE['idTestEnCours'])){
            setcookie("idTestEnCours", '', time() - 3600, "/");
        }
        if (isset($_COOKIE['idCategorieEnCours'])){
            setcookie('idCategorieEnCours','',time()-3600,"/");
        }
        if (isset($_COOKIE['XV'])){
            setcookie('XV','',time()-3600,"/");
        }
        if (isset($_COOKIE['AEnvoyer'])){
            setcookie('AEnvoyer','',time()-3600,"/");
        }



        /* @var $repositoryTest \QuizzBundle\Repository\TestRepository*/
        $repositoryTest = $em->getRepository('QuizzBundle:Test');

        $listeTest = $repositoryTest->listeTest();

        return $this->render('QuizzBundle:Test:listeTest.html.twig',[
            'listeTest'=>$listeTest]);
    }


    /**
     * @Route("test/categories")
     */
    public function categorieAction(){
        $id = $_COOKIE['idTestEnCours'];
        if (isset($_COOKIE['idCategorieEnCours'])){
            $idCategorie = $_COOKIE['idCategorieEnCours'];


            $em = $this->getDoctrine() -> getManager();
            /* @var $repositoryTest \QuizzBundle\Repository\TestRepository */
            $repositoryTest = $em->getRepository('QuizzBundle:Test');
            /* @var $repositoryQuestion \QuizzBundle\Repository\QuestionRepository */
            $repositoryQuestion = $em->getRepository('QuizzBundle:Question');
            /* @var $repositoryReponse \QuizzBundle\Repository\ReponseRepository */
            $repositoryReponse =$em->getRepository('QuizzBundle:Reponse');
            /* @var $repositoryCategorie \QuizzBundle\Repository\CategorieRepository */
            $repositoryCategorie =$em->getRepository('QuizzBundle:Categorie');

            $premiereCategorieDuTest = $repositoryCategorie->PremiereCategorieDuTest($id);
            //var_dump($premiereQuestionDeLaCategorie);
            $derniereCategorieDuTest = $repositoryCategorie->DerniereCategorieDuTest($id);
            //var_dump($derniereCategorieDuTest );

            //Recupération de l'id de la derniere question de la categorie
            $DerniereQuestionDeLaCategorie = $repositoryQuestion->DerniereQuestionDeLaCategorie($idCategorie);
            foreach ($DerniereQuestionDeLaCategorie as $DerniereQuestion){
                $idDerniereQuestion = $DerniereQuestion->getId();
            }
            //Reccuperer le cookie resultat

            if (isset($_COOKIE['XV']) ){
                $valeurXV = $_COOKIE['XV'].'';
            }else{
                $valeurXV='';
            }
            //var_dump($valeurXV);

            //Code pour le calcul du resultat de test de la categorie
            if (isset($_COOKIE['idCategorieEnCours']) ){
                $listeQuestionCateg = $repositoryQuestion->listeQuestionParCategorie($_COOKIE['idCategorieEnCours']);
                foreach ($listeQuestionCateg as $questionCateg) {
                    $idQuestionCateg = $questionCateg->getId();

                    $nomCookie = "RepQuest$idQuestionCateg";
                    //Si le cookie de la reponse est connue donc il y a repondu
                    if (isset($_COOKIE[$nomCookie])) {
                        //Recupération d'un int qui coresspond à la valeur de l'id de la reponse choisi
                        $idRep = $_COOKIE[$nomCookie] . '';
                        //Verification en base si l'id est une reponse bonne ou pas
                        $reponse = $repositoryReponse->EstBonne($idRep);
                        foreach ($reponse as $estBonne) {
                            $laReponseEstBonne = $estBonne->getEstBonne();
                        }
                        //$id est une mauvaise reponse?
                        if ($laReponseEstBonne == false) {
                            //Ajouter 'X'
                            $valeurXV =$valeurXV.'X';
                        }
                        else{
                            //Si la réponse est bonne Ajouter 'V'
                            $valeurXV =$valeurXV.'V';
                        }
                        //Suppression des cookies qui sauvegarde les reponse
                        setcookie("$nomCookie", '', time() - 3600, "/");
                    }
                    //S'il n'est pas connu donc pas de reponse à cette question, afficher un tiret '-'
                    else{
                        $valeurXV = $valeurXV.'-';
                    }
                }
            }

            //Renvoyer le cookie du res à jour apres le traitement
            setcookie('XV',$valeurXV,time()+3600*24*1000,'/');


            foreach ($derniereCategorieDuTest as $derniereCategorie){
                $idDernierCategorie = $derniereCategorie->getId();
            }
            //var_dump($idDernierCategorie);
            /*return $this->render('QuizzBundle:Resultat:resultat.html.twig');*/
            $listeCategorieDuTest =$repositoryCategorie->getCategorieSuivante($idCategorie,$id);
            //var_dump($listeCategorieDuTest);
            if ($idCategorie != $idDernierCategorie){

                return $this -> render('QuizzBundle:Test:listecategorie.html.twig',
                    [
                        'listeCategories'=>$listeCategorieDuTest,
                        'premiereCategorieDuTest'=>$premiereCategorieDuTest,
                        '$derniereCategorieDuTest'=>$derniereCategorieDuTest
                    ]);
            }


            if (isset($_COOKIE['idTestEnCours'])){
                try{
                    date_default_timezone_set('Europe/Paris');
                    $idResTest = $_COOKIE['idTestEnCours'];
                    $Test = $repositoryTest->findOneById($idResTest);
                    $libelleTest = $Test->getLibelle();
                    $date = date("j/n/Y H:i:s");
                    $Texte="";
                    $Texte1 = "Passage du test : $libelleTest le $date";
                    $tabScore[] = $Texte1;
                    $comp = 0;
                    $nbQuestionTest = 0;
                    $nbBonneReponseTest = 0;
                    //Boucle sur les categorie du Test
                    $repositoryCategorie = $em->getRepository('QuizzBundle:Categorie');
                    $listeCategorieDuTest = $repositoryCategorie->listeCategorieDuTest($_COOKIE['idTestEnCours']);
                    foreach ($listeCategorieDuTest as $categorieDuTest){
                        $nbQuestionCate = 0;
                        $nomCategorie = $categorieDuTest->getLibelle();
                        $idCategorie = $categorieDuTest->getId();
                        $texteCategorie='';
                        $texteCategorie = $texteCategorie." $nomCategorie ";
                        $tabScore[] = $texteCategorie;
                        $listeQuestionDeLaCategorie = $repositoryQuestion->listeQuestionParCategorie($idCategorie);
                        //Boucle sur les questions de la categorie
                        $nbBonneReponseCate =0;
                        foreach ($listeQuestionDeLaCategorie as $questionDeLaCategorie){
                            $nomQuestion = $questionDeLaCategorie->getLibelle();
                            $texteQuestion = '';
                            $texteQuestion.= "$nomQuestion ";
                            $nbQuestionCate++;
                            // Ajout pour chacune des question le resultat associé
                            if (isset($_COOKIE['XV'])){
                                $valeurXVATraiter = $_COOKIE['XV'].'';
                                //var_dump($_COOKIE['XV']);
                                $valeurDeLaReponse = $valeurXVATraiter[$comp];

                                if ($valeurDeLaReponse =='V'){
                                    $nbBonneReponseCate++;
                                    //var_dump($nbBonneReponseCate);
                                    //Affichage de la liste de question sous forme d'un tableau
                                }
                                $comp++;
                                //var_dump($comp);
                                $texteQuestion.="[$valeurDeLaReponse]";
                                $tabScore[] = $texteQuestion;
                            }
                        }
                        $texteResultatCategorie= "Resultat de la Categorie $nbBonneReponseCate / $nbQuestionCate ";
                        $tabScore[] = $texteResultatCategorie;
                        $nbQuestionTest+= $nbQuestionCate;
                        $Texte = $Texte.$texteCategorie;
                        $nbBonneReponseTest+=$nbBonneReponseCate;
                    }
                    $TexteTest= "Le resultat du Test  $nbBonneReponseTest / $nbQuestionTest";
                    $tabScore[] = $TexteTest;
                    //var_dump($tabScore);
                    //var_dump($Texte);
                }
                catch ( \Exception $e){
                    $e->getMessage();
                }
            }
            if (isset($_COOKIE['AEnvoyer'])) {
                if ($_COOKIE['AEnvoyer'].''== 1){
                    $message = \Swift_Message::newInstance();
                    $message->setSubject($libelleTest);
                    $message->setFrom('maxime.theard@slickteam.fr');
                    $message->setTo('maxime.theard@slickteam.fr');
                    $message->setBody($this->render('QuizzBundle:Test:listecategorie.html.twig',
                        [
                            'tabScore' => $tabScore
                        ]), 'text/html');
                    $this->get('mailer')->send($message);
                    setcookie('AEnvoyer',2,time()+3600*24*1000,"/");

                    return $this->render('QuizzBundle:Test:listecategorie.html.twig');
                }
                else{
                    return $this->render('QuizzBundle:Test:listecategorie.html.twig');
                }
            }
            else{
                setcookie('AEnvoyer',1,time()+3600*24*1000,"/");
                return $this->render('QuizzBundle:Test:listecategorie.html.twig');
            }
        }
        else{
            $em = $this->getDoctrine() -> getManager();
            /* @var $repositoryQuestion \QuizzBundle\Repository\QuestionRepository */
            $repositoryQuestion = $em->getRepository('QuizzBundle:Question');
            /* @var $repositoryReponse \QuizzBundle\Repository\ReponseRepository */
            $repositoryReponse =$em->getRepository('QuizzBundle:Reponse');
            /* @var $repositoryCategorie \QuizzBundle\Repository\CategorieRepository */
            $repositoryCategorie =$em->getRepository('QuizzBundle:Categorie');
            $premiereCategorieDuTest = $repositoryCategorie->PremiereCategorieDuTest($id);
            //var_dump($premiereQuestionDeLaCategorie);
            foreach ($premiereCategorieDuTest as $PremiereCategorie){
                $idPremiereCategorie = $PremiereCategorie->getId();
            }
            $listeCategorieDuTest =$repositoryCategorie->PremiereCategorieDuTest($id);
            //var_dump($listeCategorieDuTest);
            /* @var $repositoryTest \QuizzBundle\Repository\TestRepository */
            $repositoryTest = $em->getRepository('QuizzBundle:Test');
            $derniereCategorieDuTest = $repositoryCategorie->DerniereCategorieDuTest($id);
            //var_dump($derniereQuestionDeLaCategorie );
            /*return $this->render('QuizzBundle:Resultat:resultat.html.twig');*/
            return $this -> render('QuizzBundle:Test:listecategorie.html.twig',
                [
                    'listeCategories'=>$listeCategorieDuTest,
                    'premiereCategorieDuTest'=>$premiereCategorieDuTest,
                    '$derniereCategorieDuTest'=>$derniereCategorieDuTest
                ]
            );
        }
    }

    /**
     * @Route("test/categories/questions")
     */
    public function questionAction(){

        $id = $_COOKIE['idCategorieEnCours'];

        $em = $this->getDoctrine() -> getManager();
        /* @var $repositoryQuestion \QuizzBundle\Repository\QuestionRepository */
        $repositoryQuestion = $em->getRepository('QuizzBundle:Question');
        /* @var $repositoryReponse \QuizzBundle\Repository\ReponseRepository */
        $repositoryReponse =$em->getRepository('QuizzBundle:Reponse');
        /* @var $repositoryCategorie \QuizzBundle\Repository\CategorieRepository */
        $repositoryCategorie =$em->getRepository('QuizzBundle:Categorie');

        $nomCategorie =$repositoryCategorie->findOneById($id);
        $listeQuestionDeLaCategorie =$repositoryQuestion->listeQuestionParCategorie($id);
        //var_dump($listeQuestionDeLaCategorie);

        foreach ($listeQuestionDeLaCategorie as $question)
        {
            $idQuestion = $question->getId();
            $libelleQuestion = $question->getLibelle();
            //var_dump($idQuestion .' '.$libelleQuestion  );
            $listeReponseDeLaQuestion = $repositoryReponse->listeReponseParQuestion($idQuestion);
            $nbRep = sizeof($listeReponseDeLaQuestion);
            //var_dump($nbRep);

            foreach ($listeReponseDeLaQuestion as $reponse)
            {
                $idRep = $reponse->getId();
                $libelleRep = $reponse->getLibelle();
                //var_dump($idRep.' '.$libelleRep);
                $tableauReponses[] = $reponse;
            }
        }
        $premiereQuestionDeLaCategorie = $repositoryQuestion->PremiereQuestionDeLaCategorie($id);
        //var_dump($premiereQuestionDeLaCategorie);

        $derniereQuestionDeLaCategorie = $repositoryQuestion->DerniereQuestionDeLaCategorie($id);
        //var_dump($derniereQuestionDeLaCategorie );

        /*return $this->render('QuizzBundle:Resultat:resultat.html.twig');*/
        return $this -> render('QuizzBundle:Test:affichagequestion.html.twig',
            [
                'categorie' => $nomCategorie,
                'listeQuestions' => $listeQuestionDeLaCategorie,
                'listeReponses' => $tableauReponses,
                'premiereQuestionDeLaCategorie'=>$premiereQuestionDeLaCategorie,
                'derniereQuestionDeLaCategorie'=>$derniereQuestionDeLaCategorie
            ]
        );
    }
}
