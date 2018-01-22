<?php

class MSpecialities
{
    private $conn;
    private $primary_key;
    private $value;

    public function __construct($_primary_key = null){
        $this->conn = new PDO(DATABASE,LOGIN,PASSWORD);
        $this->primary_key = $_primary_key;
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function SetValue($_value){
        $this->value = $_value;
    }

    public function SelectAll(){
        $query = '
        select S.ID_SPECIALITY, S.SPECIALITY, S.SPECIALITY_DESCRIPTION
        from SPECIALITIES S
        ';

        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));
        return $result->fetchAll();

    }
}