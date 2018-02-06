<?php

class MDays{
    private $conn;
    private $primary_key;
    private $value;

    //Toujours respecter la syntaxe $_ des variables de portée locale

    public function __construct($_primary_key = null){
        $this->conn = new PDO(DATABASE,LOGIN,PASSWORD);
        $this->primary_key = $_primary_key;
    }

    public function __destruct(){
    }

    public function SetValue($_value){
        $this->value = $_value;
    }

    public function SelectDays(){
        $query = '
          SELECT D.LASTNAME, D.PHONENUMBER, D.MAIL, H.HOURS, DA.DAYNAME
          FROM DOCTORS D, DAYS DA, HOURS H, DAYS_HOURS DH, DOCTORS_DAYS DD
          WHERE D.ID_DOCTOR = DD.ID_DOCTOR
          AND DD.ID_DAY = DA.ID_DAY
          AND DA.ID_DAY = DH.ID_DAY
          AND DH.ID_HOUR = H.ID_HOUR
          GROUP BY DA.DAYNAME
          ORDER BY DA.ID_DAY
          ';
        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));

        return $result->fetchAll();
    }
}