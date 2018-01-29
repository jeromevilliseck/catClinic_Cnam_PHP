<?php

class VDoctors{
    public function __construct(){}

    public function __destruct(){}

    public function showList($_data){


        /*TODO Maintenabilité et réutilisabilité à augmenter
        Supprimer les dépendances en algorithmie pour aller vers un code générique
        Intégrer les boucles "spécialité des docteurs" dans une portée plus basse en remplaçant l'indice par ID_DOCTOR
        */

        //Spécialité du premier docteur $_data[1]->Remain (couple indice / objet de type PDO::fetchAll()
        $variableRemain = '';
        foreach ($_data[1] as $local){
            $variableRemain .= '<li>'.$local['SPECIALITY'].'</li>';
        }

        //Spécialité du deuxième docteur $_data[2]->Burlotte
        $variableBurlotte = '';
        foreach ($_data[2] as $local){
            $variableBurlotte .= '<li>'.$local['SPECIALITY'].'</li>';
        }

        //Spécialité du troisième docteur $_data[3]->Abeauveaux
        $variableAbeauveaux = '';
        foreach ($_data[3] as $local){
            $variableAbeauveaux .= $local['SPECIALITY'].' ';
        }

        //Boucle sur tuples
        $tr = '';

        //Ajout de création ou pas de contenu dynamiquement via des conditions ternaires
        foreach ($_data[0] as $val){
            ($val['ID_DOCTOR'] != NULL) ? $doctorNumber = '<span>'.$val['ID_DOCTOR'].'</span>' : $doctorNumber = NULL;
            ($val['LASTNAME'] != NULL) ? $doctorLastName = '<span>'.$val['LASTNAME'].'</span>' : $doctorLastName = NULL;
            ($val['FIRSTNAME'] != NULL) ? $doctorFirstName = '<span>'.$val['FIRSTNAME'].'</span>' : $doctorFirstName = NULL;
            ($val['TYPEDOCTOR'] != NULL) ? $doctorTypeDoctor = '<h3>'.$val['TYPEDOCTOR'].'</h3>' : $doctorTypeDoctor = NULL;
            ($val['PHONENUMBER'] != NULL) ? $doctorPhoneNumber = '<p><a href="tel:+(33)'.$val['PHONENUMBER'].'">0'.$val['PHONENUMBER'].'</a></p>' : $doctorPhoneNumber = NULL;
            ($val['MAIL'] != NULL) ? $doctorMail = '<p><a href="mailto:'.$val['MAIL'].'">'.$val['MAIL'].'</a></p>' : $doctorMail = NULL;
            ($val['PORTRAIT'] != NULL) ? $doctorPortrait = '<p><img src="'.$val['PORTRAIT'].'"></p>' : $doctorPortrait = NULL;

            //Affectation d'une variable contenant la boucle sur les resultats issue de l'objet venant de la requete select avec les jointures
            //TODO Intéressant : on ne peut pas faire une boucle classique puisque a chaque passage on réaffecterais la variable locale
            //Essayer de sortir de ce problème car sinon il va falloir une variable locale pour chaque $variable issue d'une boucle sur la requete issue des jointures
            ($val['ID_DOCTOR'] == 1) ? $dS1 = '<h4> Spécialité : '.$variableRemain.'</h4>' : $dS1 = NULL;
            ($val['ID_DOCTOR'] == 2) ? $dS2 = '<h4> Spécialité : '.$variableBurlotte.'</h4>' : $dS2 = NULL;
            ($val['ID_DOCTOR'] == 3) ? $dS3 = '<h4> Spécialité :'.$variableAbeauveaux.'</h4>' : $dS3 = NULL;
            //Fin de la portion spécifique

            (($val['ID_DOCTOR'] || $val['LASTNAME'] || $val['FIRSTNAME'] || $val['TYPEDOCTOR'] || $val['PHONENUMBER'] || $val['MAIL'] || $val['PORTRAIT']) != NULL) ? $articleStart = '<article>' : $articleStart = NULL;
            (($val['ID_DOCTOR'] || $val['LASTNAME'] || $val['FIRSTNAME'] || $val['TYPEDOCTOR'] || $val['PHONENUMBER'] || $val['MAIL'] || $val['PORTRAIT']) != NULL) ? $articleEnd = '</article>' : $articleEnd = NULL;

            (($val['ID_DOCTOR'] && $val['LASTNAME'] && $val['FIRSTNAME']) != NULL) ? $headerStart = '<header><h2>' : $headerStart = NULL;
            (($val['ID_DOCTOR'] && $val['LASTNAME'] && $val['FIRSTNAME']) != NULL) ? $headerEnd = '</h2></header>' : $headerEnd = NULL;

            (($val['TYPEDOCTOR'] || $val['PORTRAIT']) != NULL) ? $sectionStart = '<section>' : $sectionStart = NULL;
            (($val['TYPEDOCTOR'] || $val['PORTRAIT']) != NULL) ? $sectionEnd = '</section>' : $sectionEnd = NULL;

            (($val['PHONENUMBER'] && $val['MAIL']) != NULL) ? $footerStart = '<footer>' : $footerStart = NULL;
            (($val['PHONENUMBER'] && $val['MAIL']) != NULL) ? $footerEnd = '</footer>' : $footerEnd = NULL;

            $tr .= ''.$articleStart.'
            '.$headerStart.''.$doctorNumber.' : '.$doctorFirstName.' '.$doctorLastName.''.$headerEnd.'
            '.$sectionStart.''.$doctorTypeDoctor.''.$doctorPortrait.''.$dS1.''.$dS2.''.$dS3.''.$sectionEnd.'
            '.$footerStart.''.$doctorPhoneNumber.''.$doctorMail.''.$footerEnd.'
            '.$articleEnd.'
            ';
        }

        echo <<<HERE
        <br/>
            $tr
HERE;

    }
}