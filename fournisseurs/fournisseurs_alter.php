<?php
if(isset($_GET['id'])) {
    $ID = $_GET['id'];
    $choice = $_GET['choice'];
}
else die("Submission error");
switch ($choice) {
    case 'delete' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_delete/delete_fournisseur_process.php?id=$ID");
                    break;
    case 'modifie' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_modifie/modifie_fournisseur_interface.php?id=$ID");
                    break;
    case 'articles' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_search/search_per_fournisseur.php?id=$ID");
                    break;
    default : echo 'ERROR : NO CHOICE';
}