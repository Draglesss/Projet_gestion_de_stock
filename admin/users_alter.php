<?php
$ID = $_GET['id'];
$choice = $_GET['choice'];
switch ($choice){
    case 'delete' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_delete/delete_user_process.php?id=$ID");break;
    case 'modifie' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_modifie/modifie_user_interface.php?id=$ID");break;
    case 'log' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/logger.php?id=$ID");break;
    default : die('Submission error');
}