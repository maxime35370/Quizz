<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 17/10/2017
 * Time: 12:02
 */

namespace QuizzBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ResultatController extends Controller
{
    /**
     * @Route("/resultat")
     */
    public function resultatAction (){


        //Recuperation du cookie de la question ... et traitement si le choix est .... ou ....
        $em = $this->getDoctrine() -> getManager();
        /* @var $repositoryProfil \QuizzBundle\Repository\ProfilRepository */
        $repositoryProfil = $em->getRepository('QuizzBundle:Profil');
        /*
        //Exemple pour réccupération des reponse des question id 11 et 12

        //Recuppération des cookies appartenant à ces questions s'il existe

        if (isset($_COOKIE['repQuestion11'])) {
            $reponseChoisiDeQuest11 = $_COOKIE['repQuestion11'].'';

        }
        if (isset($_COOKIE['repQuestion12'])) {
            $reponseChoisiDeQuest12 = $_COOKIE['repQuestion12'];

        }

        // Attribution des profils par rapport au choix de réponse par question

        if ($reponseChoisiDeQuest11 == '13'){
            if ($reponseChoisiDeQuest12 == '15'){
                $profilAAfficher = $repositoryProfil->findOneById(2);
            }
            else{
                $profilAAfficher = $repositoryProfil->findOneById(4);
            }
        }
        else{
            if ($reponseChoisiDeQuest12 == '15'){
                $profilAAfficher = $repositoryProfil->findOneById(3);
            }
            else{
                $profilAAfficher = $repositoryProfil->findOneById(5);
            }
        }*/

        if (isset($_COOKIE['repQuestion44'])) {
            $reponseChoisiDeQuest44 = $_COOKIE['repQuestion44'].'';

        }
        if (isset($_COOKIE['repQuestion46'])) {
            $reponseChoisiDeQuest46 = $_COOKIE['repQuestion46'].'';

        }

        if ($reponseChoisiDeQuest44 == '111'){ //Homme 111
            if ($reponseChoisiDeQuest46 == '116'){
                $profilAAfficher = $repositoryProfil->findOneById(6);
            }
            elseif($reponseChoisiDeQuest46 == '117'){
                $profilAAfficher = $repositoryProfil->findOneById(9);
            }
            elseif($reponseChoisiDeQuest46 == '118'){
                $profilAAfficher = $repositoryProfil->findOneById(10);
            }
            elseif($reponseChoisiDeQuest46 == '119'){
                $profilAAfficher = $repositoryProfil->findOneById(13);
            }
            elseif($reponseChoisiDeQuest46 == '120'){
                $profilAAfficher = $repositoryProfil->findOneById(14);
            }
            elseif($reponseChoisiDeQuest46 == '121'){
                $profilAAfficher = $repositoryProfil->findOneById(16);
            }
            elseif($reponseChoisiDeQuest46 == '122'){
                $profilAAfficher = $repositoryProfil->findOneById(19);
            }
            elseif($reponseChoisiDeQuest46 == '123'){
                $profilAAfficher = $repositoryProfil->findOneById(21);
            }
            elseif($reponseChoisiDeQuest46 == '124'){
                $profilAAfficher = $repositoryProfil->findOneById(22);
            }
            elseif($reponseChoisiDeQuest46 == '125'){
                $profilAAfficher = $repositoryProfil->findOneById(24);
            }
            elseif($reponseChoisiDeQuest46 == '126'){
                $profilAAfficher = $repositoryProfil->findOneById(27);
            }
            else{ //127
                $profilAAfficher = $repositoryProfil->findOneById(28);
            }

        }
        else{
            if ($reponseChoisiDeQuest46 == '116'){
                $profilAAfficher = $repositoryProfil->findOneById(7);
            }
            elseif($reponseChoisiDeQuest46 == '117'){
                $profilAAfficher = $repositoryProfil->findOneById(8);
            }
            elseif($reponseChoisiDeQuest46 == '118'){
                $profilAAfficher = $repositoryProfil->findOneById(11);
            }
            elseif($reponseChoisiDeQuest46 == '119'){
                $profilAAfficher = $repositoryProfil->findOneById(12);
            }
            elseif($reponseChoisiDeQuest46 == '120'){
                $profilAAfficher = $repositoryProfil->findOneById(15);
            }
            elseif($reponseChoisiDeQuest46 == '121'){
                $profilAAfficher = $repositoryProfil->findOneById(17);
            }
            elseif($reponseChoisiDeQuest46 == '122'){
                $profilAAfficher = $repositoryProfil->findOneById(18);
            }
            elseif($reponseChoisiDeQuest46 == '123'){
                $profilAAfficher = $repositoryProfil->findOneById(20);
            }
            elseif($reponseChoisiDeQuest46 == '124'){
                $profilAAfficher = $repositoryProfil->findOneById(23);
            }
            elseif($reponseChoisiDeQuest46 == '125'){
                $profilAAfficher = $repositoryProfil->findOneById(25);
            }
            elseif($reponseChoisiDeQuest46 == '126'){
                $profilAAfficher = $repositoryProfil->findOneById(26);
            }
            else{ //127
                $profilAAfficher = $repositoryProfil->findOneById(29);
            }
        }

        return $this->render('QuizzBundle:Resultat:resultat.html.twig',[
            'profil'=> $profilAAfficher
        ]);

    }


}