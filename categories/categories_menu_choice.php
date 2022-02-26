<?php
if(isset($_POST['choice'])) {
    switch ($_POST['choice']){
        case 'Chercher' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_search/search_categorie.php"); 
                          break;
        case 'Ajouter' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_add/add_categorie.php"); 
                         break;
        case 'Supprimer' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_delete/delete_categorie.php"); 
                           break;
        case 'Modifier' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_modifie/modifie_categorie_interface.php"); 
                          break;
        default : die("ERROR : Submission error"); //* case where $_POST['choice'] has none of wanted values
    }
}