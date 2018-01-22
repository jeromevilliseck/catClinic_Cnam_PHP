<?php

class VSpecialities
{
    public function __construct(){}

    public function __destruct(){}

    public function showList($_data){

        //Boucle sur tuples
        $tr = '';

        foreach ($_data as $val){
            ($val['ID_SPECIALITY'] != NULL) ? $specialityId = '<span>'.$val['ID_SPECIALITY'].'</span>' : $specialityId = NULL;
            ($val['SPECIALITY'] != NULL) ? $specialityName = '<span>'.$val['SPECIALITY'].'</span>' : $specialityName = NULL;
            ($val['SPECIALITY_DESCRIPTION'] != NULL) ? $specialityDescription = '<span>'.$val['SPECIALITY_DESCRIPTION'].'</span>' : $specialityDescription = NULL;

            $tr .= '<article>
                        <header>
                            <h3>Spécialité n°'.$specialityId.'</h3></header>
                        <section>
                            <h4>'.$specialityName.'</h4>
                            '.$specialityDescription.' 
                        </section>
                    </article>
            '; /*Attention ne pas englober $specialityDescription dans des balises <p>, car les listes et autres elements de type block inline block
            doivent être au même niveau que les paragraphes en imbrication, placer les balises de ce type directement dans l'occurence SQL*/
        }

        echo <<<HERE
        <br/>
            $tr
HERE;
    }
}