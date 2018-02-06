<?php

class MDoctors extends MGlobal{

//PARTIE OPERANT SUR L'ENSEMBLE DES TUPLES

    public function SelectAll(){
        $query = '
        select D.ID_DOCTOR, D.LASTNAME, D.FIRSTNAME, D.TYPEDOCTOR, D.PHONENUMBER, D.MAIL, D.PORTRAIT
        from DOCTORS D
        ';
        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();

    }

    public function SelectSpecialities($_idDoctor){
        $query = '
        SELECT S.SPECIALITY FROM SPECIALITIES S, DOCTORS_SPECIALITIES DS, DOCTORS D
        WHERE S.ID_SPECIALITY = DS.ID_SPECIALITY
        AND DS.ID_DOCTOR = D.ID_DOCTOR
        AND D.ID_DOCTOR = "'.$_idDoctor.'"
        ';

        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();
    }

    public function SelectCount(){
        $query = '
        SELECT * FROM DOCTORS
        ';

        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));

        return $result->rowCount(); //Attention il faut utiliser la méthode rowCount de la classe PDOStatement et non par faire un SELECT count avec un return result car on va sinon renvoyer un objet
    }

//PARTIE OPERANT SUR UN SEUL TUPLE

    public function Select()
    {
        $query = "select ID_DOCTOR,
                     LASTNAME,
                     FIRSTNAME,
                     TYPEDOCTOR,
                     PHONENUMBER,
                     MAIL,
                     PORTRAIT
              from DOCTORS
              where ID_DOCTOR = $this->primary_key"; //Récupérée au moment de l'instanciation -> Voir la classe mère MGlobal

        $result = $this->conn->prepare($query);

        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetch();

    } // Select()
}