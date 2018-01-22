<?php
require('../../core/autoloader/autoloader.php'); //Chargement dynamique des classes selon l'instanciation
require('../../config/configDatabase.php'); //Constantes de connexion à la base de données
require('../../config/configGenericValues.php'); //Constantes génériques propre au site


//Variable de contrôle
$EX = isset ($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home'; //Contrôle via condition ternaire

//Controleur
switch ($EX)
{
    case 'home' : home(); break;
    case 'team' : team(); break;
    case 'spec' : specialities(); break;
    default : home(); break;
}

//Fonctions de contrôle
function home(){
    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Vous êtes à : Accueil</p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/home.html';

    $content['vign'] = ''; //Vignette de partage pour les réseaux sociaux, affectation variable de l'image selon la page

    return;
}

function team(){

    $mdoctors = new MDoctors();
    $data = $mdoctors->SelectAll();

    /*Requête avec jointure pour connaitre les spécialités par médecin
    La condition de la requête SQL est remplacée par une paramètre de la méthode*/
    $data_remain = $mdoctors->SelectSpecialities("Remain");
    $data_burlotte = $mdoctors->SelectSpecialities("Burlotte");
    $data_abeauveaux = $mdoctors->SelectSpecialities("Abeauveaux");

    //Création d'une collection d'objets accessibles par indices
    $arrObj = array();
    $arrObj[0] = $data; //Contient les données des médecins
    $arrObj[1] = $data_remain; //Contient les spécialités exercées par le medecin passé en paramètre de la méthode
    $arrObj[2] = $data_burlotte;
    $arrObj[3] = $data_abeauveaux;

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Vous êtes à : Docteurs</p>';
    $content['class'] = 'VDoctors';
    $content['method'] = 'showList';
    $content['arg'] = $arrObj;

    $content['vign'] = '';

    return;
}

function specialities(){

    $mspecialities = new MSpecialities();
    $data = $mspecialities->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Vous êtes à : Spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = 'showList';
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

// Mise en page
require('../../pages/templates/layout.view.php');