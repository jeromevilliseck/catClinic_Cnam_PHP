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
    case 'advi' : advices(); break;
    case 'adre' : address(); break;
    case 'rdva' : appointment(); break;
    case 'hour' : hours(); break;

    case 'doct' : doctor(); break;

    default : home(); break;
}

//Fonctions de contrôle

function home(){

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Accueil - Clinique vétérinaire de Jarcieux</p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/home.html';

    $content['vign'] = ''; //Vignette de partage pour les réseaux sociaux, affectation variable de l'image selon la page -> Attention fb et autres for developpers précisent qu'ils veulent des liens absolus pas relatifs

    return;
}

function team(){

    $mdoctors = new MDoctors();
    $data = $mdoctors->SelectAll();

    $rowCount = $mdoctors->SelectCount(); //Pas de paramètre 'TABLE' dans la fonction puisque une classe modèle est rattaché à une table dans la méthode vue en cours
    //On à récupéré le nombre de tuples

    //Vers de la généricité avec des liaisons SQL...
    $arrObjLocal = array(); //Obligation de passer par un objet collection pour sortir de la problématique de portée locale
    for ($i = 1; $i <= $rowCount; $i++) { //Attention car l'indice 0 de l'objet $arrObj contient l'objet PDO sur lequel est appliqué la méthode fetchAll() ne pas se faire piéger;

        $dataLocal = $mdoctors->SelectSpecialities($i);

        $arrObjLocal[$i] = $dataLocal;

        //Ne pas mettre de return ici car on est pas dans une fonction mais dans une structure de contrôle de portée locale
    }

    /*Requête avec jointure pour connaitre les spécialités par médecin
    La condition de la requête SQL est remplacée par une paramètre de la méthode*/
    //TODO Mise en place de code générique dans le contrôleur

    /*Ancien code non générique pour montrer l'évolution
    $data_remain = $mdoctors->SelectSpecialities(1);
    $data_burlotte = $mdoctors->SelectSpecialities(2);
    $data_abeauveaux = $mdoctors->SelectSpecialities(3);
    */

    //Création d'une collection d'objets accessibles par indices
    $arrObj = array();
    $arrObj[0] = $data; //Contient les données des médecins

    for ($i = 1; $i <= $rowCount; $i++) {
        $arrObj[$i] = $arrObjLocal[$i]; //Contient les spécialités exercées par le medecin passé en paramètre de la méthode
        $arrObj[$i] = $arrObjLocal[$i];
        $arrObj[$i] = $arrObjLocal[$i];
    }

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Les praticiens</p>';
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
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Nos spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = 'showList';
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function advices(){

    $madvices = new MAdvices();
    $data = $madvices->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Vous êtes à : Conseils</p>';
    $content['class'] = 'VAdvices';
    $content['method'] = 'showList';
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function appointment(){

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Vous souhaitez prendre Rendez-vous<br><a href="http://supersaas.fr/schedule/catclinic2018/prise_de_rdv_avec_un_praticien">Cliquez ici pour prendre rdv avec votre mobile</a></p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/appointment.html';

    $content['vign'] = '';

    return;
}

function hours(){

    $mdays = new MDays();
    $data = $mdays->SelectDays();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Accès > Nos horaires d\'ouverture</p>';
    $content['class'] = 'VDays';
    $content['method'] = 'showTable';
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function address(){

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Accès > Notre addresse</p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/address.html';

    $content['vign'] = '';

    return;
}


function doctor(){

    global $content;

    if (isset($_GET['ID_DOCTOR'])) {
        $mdoct = new MDoctors($_GET['ID_DOCTOR']);

        $data = $mdoct->Select();
    }
    else
    {
        $data = '';
    }

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>Clinique > Equipe > Fiche du spécialiste</p>';
    $content['class'] = 'VDoctors';
    $content['method'] = 'showDoctor';
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}



// Mise en page
require('../../pages/templates/layout.view.php');