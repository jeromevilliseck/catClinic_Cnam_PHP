<?php
global $content, $globaldata; //Variable globale contenant le non du site

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
  <?php $vmeta_information->showOgProperties(); $vmeta_information->showFavicon(); ?>
  <title><?=$content['title']?></title>
<link rel="stylesheet" href="css/app.css">
</head>

<body class="flex-container flex-dir-column"><!--BLOCK LEVEL 0 START-->

<div class="content"><!--BLOCK LEVEL 1 START-->

    <?php $vmenu->showMenu($globaldata['titlesite']); ?>

    <aside class="padding-aside sticky-card"><!--BLOCK LEVEL 2 START-->
        <?=$content['aside']?>
    </aside>

    <main class="padding-main"><!-- BLOCK LEVEL 2 START-->
        <?php $vcontent->{$content['method']}($content['arg']); ?>
    </main><!-- BLOCK LEVEL 2 END-->

</div><!-- BLOCK LEVEL 1 END-->

<footer class="body-footer"><!-- BLOCK LEVEL 1 START-->
    <?php $vmenu_footer->showFooter(); ?>
</footer><!-- BLOCK LEVEL 1 END-->

<!--Scripts Javascript-->
<script src="js/jquery.js"></script>
<script src="js/what-input.js"></script>
<script src="js/foundation.js"></script>
<script src="js/app.js"></script>
</body><!-- BLOCK LEVEL 0 END-->
</html>






