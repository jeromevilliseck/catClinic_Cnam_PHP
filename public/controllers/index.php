<?php
require('../../core/autoloader/autoloader.php'); //Chargement dynamique des classes selon l'instanciation
require('../../config/configDatabase.php'); //Constantes de connexion à la base de données
require('../../config/configGenericValues.php'); //Constantes génériques propre au site

// Crée une session nommée
session_name('USER');
session_start();

//Variable de contrôle
$EX = isset ($_REQUEST['EX']) ? $_REQUEST['EX'] : 'home'; //Contrôle via condition ternaire

//Controleur
switch ($EX)
{
    //Vue html standard
    case 'home' : home(); break;
    case 'adre' : address(); break;
    case 'rdva' : appointment(); break;

    //Vue avec données multiples provenant d'un modèle
    case 'team' : team(); break;

    case 'spec' : specialities(); break;
    case 'spec_ins' : specialities_form(); break; //PIEGE Attention menace de sécurité -> contrôller par isset que la superglobale existe bien dans chaque fonction de controle sinon quelqu'un pourrait saisir la clé directement dans le navigateur
    case 'spec_ins_ok' : specialities_insert(); break;
    case 'spec_upd_ok' : specialities_update(); break;
    case 'spec_del' : specialities_delete(); break;

    case 'advi' : advices(); break;
    case 'hour' : hours(); break;

    //Vue avec donnée unique provenant d'un modèle
    case 'doct' : doctor(); break;

    //Administration
    case 'admi' : administration(); break;
    case 'deco' : deconnect(); break;

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

//TODO appliquer la même conception sur les autres vues et modèles des tables team, advices, hour
//SPECIALITIES CONTROL FUNCTIONS BLOC START
function specialities(){

    $method = isset($_SESSION['ADMIN_SITE']) ? 'showListAdmin' : 'showList'; //Selon si la superglobale est présente ou pas la vue contient des données supplémentaires pour l'administrateur

    $mspecialities = new MSpecialities();
    $data = $mspecialities->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Nos spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = $method;
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function specialities_form(){

    //Sécurité pour empecher la modification de la table par un accès via la saisie de la clé dans l'url
    $method = isset($_SESSION['ADMIN_SITE']) ? 'showFormAdmin' : 'showAccessForbidden';

    //Si la clé n'est pas nul l'objet $data contient un array issue de la manipulation d'un objet avec la clé primaire id speciality
    if (isset($_GET['ID_SPECIALITY'])) {
        $mspecialities = new MSpecialities($_GET['ID_SPECIALITY']);
        $data = $mspecialities->Select();
    }
    else {
        $data = '';
    }

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Mode administration';
    $content['aside'] = '<h1>Edition : mode administrateur</h1>';
    $content['class'] = 'VSpecialities';
    $content['method'] = $method;
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function specialities_insert(){

    $method = isset($_SESSION['ADMIN_SITE']) ? 'showListAdmin' : 'showAccessForbidden';

    $mspecialities = new MSpecialities();
    //Modifier le membre value de la classe mère avec les données du formulaire
    $mspecialities->SetValue($_POST);
    //Insère les données dans la table SPECIALITIES
    $mspecialities->Insert();
    //Réaffiche tous les tuples de la table en les récupérant
    $data = $mspecialities->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Mode administration';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Nos spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = $method;
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function specialities_update(){

    $method = isset($_SESSION['ADMIN_SITE']) ? 'showListAdmin' : 'showAccessForbidden';

    $mspecialities = new MSpecialities($_POST['ID_SPECIALITY']);
    $mspecialities->SetValue($_POST);
    var_dump($mspecialities);
    $mspecialities->Update();
    $data = $mspecialities->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Mode administration';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Nos spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = $method;
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}

function specialities_delete(){

    $method = isset($_SESSION['ADMIN_SITE']) ? 'showListAdmin' : 'showAccessForbidden';

    $mspecialities = new MSpecialities($_GET['ID_SPECIALITY']); //Attention c'est un lien cliquable pour DELETE donc objet get pas objet post
    $mspecialities->Delete();


    $data = $mspecialities->SelectAll();

    global $content;

    $content['title'] = ''. SITETITLE .' - '. SITEDESCRIPTION .' - Mode administration';
    $content['aside'] = '<h1>Bienvenue chez '. SITETITLE .'</h1><p>La clinique > Nos spécialités</p>';
    $content['class'] = 'VSpecialities';
    $content['method'] = $method;
    $content['arg'] = $data;

    $content['vign'] = '';

    return;
}
//SPECIALITIES CONTROL FUNCTIONS BLOC END

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

function administration(){
    $_SESSION['ADMIN_SITE'] = true; //Superglobale crée

    home();

    return;
}

function deconnect(){
        // Détruit la session
        session_destroy();
        // Détruit les variables de session
        $_SESSION = array();

        // Redirection vers la page d'accueil
        header('Location: ../controllers');

        return;
}

// Mise en page
require('../../pages/templates/layout.view.php');