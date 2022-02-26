<?php
if(isset($_GET['id'])) {
    $ID = $_GET['id'];
    $choice = $_GET['choice'];
}
else die("ERROR : Submission error");
switch ($choice) {
    case 'delete' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_delete/delete_categorie_process.php?id=$ID");
                    break;
    case 'modifie' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_modifie/modifie_categorie_interface.php?id=$ID");
                     break;
    case 'articles' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_search/search_per_categorie.php?id=$ID");
                      break;
    default : echo 'ERROR : NO CHOICE';
}
