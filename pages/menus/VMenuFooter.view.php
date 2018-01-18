<?php
class VMenu {
    private $siteTitle; //Titre du site, variable

    public function __construct() {
    }

    public function __destruct() {
    }

    public function showMenu($_siteTitle = null) {
        $this->siteTitle = $_siteTitle;
        echo <<<'NOW'
        <header class="title-bar" data-responsive-toggle="monmenu"><!--BLOCK LEVEL 2 START-->
            <button class="menu-icon" type="button" data-toggle></button><!--INLINE BLOCK LEVEL 3 START/END-->
            <div class="title-bar-title">"$siteTitle"</div><!--BLOCK LEVEL 3 START/END-->
        </header><!--BLOCK LEVEL 2 END-->
        <nav class="top-bar" id="monmenu"><!--BLOCK LEVEL 2 START-->
            <div class="top-bar-left"><!--BLOCK LEVEL 3 START-->
                <ul class="dropdown menu vertical medium-horizontal" data-responsive-menu="drilldown medium-dropdown"><!--BLOCK LEVEL 4 START-->
                    <div class="menu-logo padding-left-logo"><img src="img/icons/catclinicLogo.png"></div><!--BLOCK LEVEL 5 START/END-->
                    <li class="menu-text show-for-medium">"$siteTitle"</li><!--CHILD BLOCK LEVEL 5 START/END-->
                    <li><!--CHILD BLOCK LEVEL 5 START-->
                        <a href="#">Clinique</a><!--INLINE-->
                        <ul class="menu vertical"><!--BLOCK LEVEL 6 START-->
                            <li><a href="#">Equipe</a></li>
                            <li><a href="#">Spécialités</a></li>
                        </ul><!--BLOCK LEVEL 6 END-->
                    </li><!--CHILD BLOCK LEVEL 5 END-->
                    <li>
                        <a href="#">Conseils</a>
                        <ul class="menu vertical">
                            <li><a href="#">Vaccination</a></li>
                            <li><a href="#">A la maison</a></li>
                            <li><a href="#">Médicaments</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="#">Accès</a>
                        <ul class="menu vertical">
                            <li><a href="#">Adresse</a></li>
                            <li><a href="#">Horaires</a></li>
                            <li><a href="#">Contact</a></li>
                        </ul>
                    </li>
                </ul><!--BLOCK LEVEL 4 END-->
            </div><!--BLOCK LEVEL 3 END-->
        </nav><!--BLOCK LEVEL 2 END-->
NOW;
        return;
    } //showHeader()

    public function showFooter(){
        echo <<<'NOW'
        <h4>Information eventuellement importantes</h4>
        <p>Le pied du site</p>
NOW;
        return;
    } //showFooter()
} // Vheader