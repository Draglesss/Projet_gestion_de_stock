<?php
$choice = $_POST['choice'];
switch ($choice) {
    case 'Chercher' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_search/search_user.php"); break;
    case 'Ajouter' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_add/add_user.php"); break;
    case 'Supprimer' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_delete/delete_user.php"); break;
    case 'Modifier' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/admin/admin_modifie/modifie_user_interface.php"); break;
    case 'Logs' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/logger.php");
    default : die('SUBMISSION ERROR : NO SUBMIT VALUE');//* case where $_POST['choice'] has none of wanted values
}