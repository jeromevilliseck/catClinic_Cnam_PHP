<?php
require('../../core/autoloader/autoloader.php'); //Chargement dynamique des classes selon l'instanciation
require('../../config/config.php'); //Constantes de connexion à la base de données

//Variable de contrôle
$EX = isset ($REQUEST['EX']) ? $REQUEST['EX'] : 'home'; //Contrôle via condition ternaire

//Controleur
switch ($EX)
{
    case 'home' : home(); break;
}

//Fonction de contrôle
function home(){
    global $content;

    $content['title'] = 'CatClinic - Accueil';
    $content['aside'] = '<h1>Bienvenue chez Catclinic</h1><p>Accueil</p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/home.html';

    return;
}

//Tableau associatif global (données relative au site non à une page)
global $globaldata;

$globaldata['titlesite'] = 'CatClinic';
$globaldata['favicon'] = '../icons/catclinicLogo.png';
$globaldata['description'] = 'Clinique véterinaire Aix-en-provence';

// Mise en page
require('../../pages/templates/layout.view.php');