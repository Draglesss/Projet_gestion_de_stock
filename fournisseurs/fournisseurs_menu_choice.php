<?php
if(isset($_POST['choice'])) {
    switch ($_POST['choice']){
        case 'Chercher' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_search/search_fournisseur.php"); 
                          break;
        case 'Ajouter' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_add/add_fournisseur.php"); 
                         break;
        case 'Supprimer' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_delete/delete_fournisseur.php"); 
                           break;
        case 'Modifier' : header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_modifie/modifie_fournisseur_interface.php"); 
                          break;
        default : die("ERROR : Submission error"); //* case where $_POST['choice'] has none of wanted values
    }
}