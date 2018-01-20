<?php

class MAdvices{
    private $conn;
    private $id_advi;
    private $value;

    public function __construct($_id_advi = null) {
        // Connexion à la Base de Données
        $this->conn = new PDO(DATABASE,LOGIN,PASSWORD,array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        // Instanciation du membre identifiant
        $this->id_advi = $_id_advi;
        return;
    }

    public function __destruct() {}

    public function SetValue($_value) {
        $this->value = $_value;
        return;
    }

    public function SelectAll() {
        $query = "
          select ID_ADVICE, TYPES, SHOWED
          from ADVICES
          order by ID_ADVICE
          ";

        $result = $this->conn->prepare($query);
        $result->bindValue(':ID_ADVICE', $this->value['ID_ADVICE'], PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll();
    }
}