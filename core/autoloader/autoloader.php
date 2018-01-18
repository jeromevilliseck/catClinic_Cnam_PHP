<?php
function __autoload($class)
{
    // Inclusion des class de type Vue
    require_once('../../pages/htmls/'.$class.'.view.php');
    require_once('../../pages/menus/'.$class.'.view.php');
    require_once('../../pages/metas/'.$class.'.view.php');
    return;

} // __autoload($class)
?>