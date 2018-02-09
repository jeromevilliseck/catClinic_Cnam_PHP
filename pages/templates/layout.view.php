<?php
global $content; //Variables globales contenant le contenu et les données meta

$vmenu_footer = new VMenuFooter(); //Instanciation de la classe contenant le menu
$vmeta_information = new VMetaInformation(); //Instanciation de la classe contenant les informations meta supplementaires
$vcontent = new $content['class'](); //Instanciation d'une classe variable selon la valeur de la clé du tableau associatif $content du controleur
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php $vmeta_information->showOgProperties($content['vign']); ?>
  <title><?=$content['title']?></title>
<link rel="stylesheet" href="../../public/css/app.css">
</head>

<body class="flex-container flex-dir-column">                                           <!--BLOCK LEVEL 0 START-->
    <div class="content">                                                               <!--BLOCK LEVEL 1 START-->

        <?php $vmenu_footer->showMenu(); ?>

        <aside class="padding-aside sticky-card">                                       <!--BLOCK LEVEL 2 START-->
            <?=$content['aside']?>
        </aside>

        <main class="padding-main">                                                     <!-- BLOCK LEVEL 2 START-->
            <?php $vcontent->{$content['method']}($content['arg']); ?>
        </main>                                                                         <!-- BLOCK LEVEL 2 END-->

    </div>                                                                              <!-- BLOCK LEVEL 1 END-->

    <footer class="body-footer">                                                        <!-- BLOCK LEVEL 1 START-->
        <?php $vmenu_footer->showFooter(); ?>
    </footer>                                                                           <!-- BLOCK LEVEL 1 END-->

    <!--Framework Javascript Scripts-->
    <script src="../js/framework/jquery.js"></script>
    <script src="../js/framework/what-input.js"></script>
    <script src="../js/framework/foundation.js"></script>
    <script src="../js/framework/app.js"></script>

    <!--User Javascript Scripts-->
    <script src="../js/user/caroussel.js"></script>
</body><!-- BLOCK LEVEL 0 END-->
</html>






