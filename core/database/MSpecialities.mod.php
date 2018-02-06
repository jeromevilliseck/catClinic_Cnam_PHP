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
}