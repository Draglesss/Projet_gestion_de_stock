<?php
$ref = $_GET['ref'];
$choice = $_GET['choice'];
switch ($choice){
    case 'delete' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_delete/delete_article_process.php?ref=$ref");break;
    case 'modifie' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_modifie/modifie_article_interface.php?ref=$ref");break;
    case 'modifiestock' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_nb_stock/alter_nb_article_interface.php?ref=$ref");break;
    default : die('Submission error');
}
