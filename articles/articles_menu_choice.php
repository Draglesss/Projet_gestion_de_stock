<?php
$choice = $_POST['choice'];
switch ($choice) {
    case 'Chercher' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_search/search_article.php"); break;
    case 'Ajouter' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_add/add_article.php"); break;
    case 'Supprimer' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_delete/delete_article.php"); break;
    case 'Modifier' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_modifie/modifie_article_interface.php"); break;
    case 'Chercher par Catégorie' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_search/search_per_categorie.php"); break;
    case 'Chercher par Fournisseur' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_search/search_per_fournisseur.php"); break;
    case 'Modifier le nombre en stock' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_nb_stock/alter_nb_article_interface.php"); break;
    default : die('SUBMISSION ERROR : NO SUBMIT VALUE');//* case where $_POST['choice'] has none of wanted values
}