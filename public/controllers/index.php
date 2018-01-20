<?php
require('../../core/autoloader/autoloader.php'); //Chargement dynamique des classes selon l'instanciation
require('../../config/config.php'); //Constantes de connexion à la base de données

//Variables globales génériques au site
$siteTitle = "Catclinic"; //Titre du site
$siteIcon = '../icons/catclinicLogo.png'; //Icone de la barre de navigation
$siteDescription = 'Clinique vétérinaire à Aix en Provence'; //Description du site web
$siteFavicon = '../favicon/x.png'; //Favicon apparaissant dans les onglets
$siteImage = ''; //Vignette apparaissant lors des partages de page pour les réseaux sociaux

//Variable de contrôle
$EX = isset ($REQUEST['EX']) ? $REQUEST['EX'] : 'home'; //Contrôle via condition ternaire

//Controleur
switch ($EX)
{
    case 'home' : home($siteTitle, $siteDescription); break;
    case 'advi_list' : advi_list(); break;
}

//Fonctions de contrôle
function home($_siteTitle = null, $_siteDescription = null){
    global $content;

    $content['title'] = ''. $_siteTitle .' - '. $_siteDescription .' - Accueil';
    $content['aside'] = '<h1>Bienvenue chez Catclinic</h1><p>Accueil</p>';
    $content['class'] = 'VHtml';
    $content['method'] = 'showHtml';
    $content['arg'] = '../html/home.html';

    return;
}

function advi_list(){
    global $content;

}

//Tableau associatif global (données relative au données meta)
global $metadata;

$metadata['title'] = $siteTitle;
$metadata['description'] = $siteDescription;
$metadata['image'] = $siteImage;
$metadata['favicon'] = $siteFavicon;
$metadata['icon'] = $siteIcon;

// Mise en page
require('../../pages/templates/layout.view.php');