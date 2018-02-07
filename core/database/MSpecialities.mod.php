<?php

class MSpecialities extends MGlobal
{
    public function SelectAll(){
        $query = '
        select S.ID_SPECIALITY, S.SPECIALITY, S.SPECIALITY_DESCRIPTION
        from SPECIALITIES S
        ';

        $result = $this->conn->prepare($query);
        $result->execute() or die ($this->ErrorSQL($result));
        return $result->fetchAll();
    }

    public function Select(){
        $query = '
          select S.ID_SPECIALITY, S.SPECIALITY, S.SPECIALITY_DESCRIPTION
  	      from SPECIALITIES S
  	      where ID_SPECIALITY = :ID_SPECIALITY
        ';

        $result = $this->conn->prepare($query);

        $result->bindValue(':ID_SPECIALITY', $this->primary_key, PDO::PARAM_INT);

        $result->execute() or die ($result);

        $value = $result->fetch();

        return $value;
    }

    //TODO Reprendre ici le travail en ecrivant correctement la fonction et en controllant si l'id fait partie de la requete

    public function Insert()
    {
        $query = 'insert into SPECIALITIES (NOM, PRENOM, EMAIL)
              values(:NOM, :PRENOM, :EMAIL)';

        $result = $this->conn->prepare($query);

        $result->bindValue(':NOM', $this->value['NOM'], PDO::PARAM_STR);
        $result->bindValue(':PRENOM', $this->value['PRENOM'], PDO::PARAM_STR);
        $result->bindValue(':EMAIL', $this->value['EMAIL'], PDO::PARAM_STR);

        $result->execute() or die ($result);

        $this->id_client = $this->conn->lastInsertId();

        $this->value['ID_CLIENT'] = $this->id_client;

        return $this->value;

    } // Insert()
}