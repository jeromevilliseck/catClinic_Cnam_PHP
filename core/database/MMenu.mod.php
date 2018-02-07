<?php

class MMenu extends MGlobal{

    //Selectionne tous les tuples qui correspondent au différents liens du menu

    public function SelectAll()
    {
        $query = 'select ID_MENU, MENU, DESCRIPTION
              from MENU
   		      order by ID_MENU';

        $result = $this->conn->prepare($query);

        $result->execute() or die ($this->Error($result));

        return $result->fetchAll();

    } // SelectAll()

}