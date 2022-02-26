<?php
if(isset($_POST["choice"])) {
    switch($_POST['choice']) {
        case  'Acceder aux Articles' :
            header("Location: http://localhost/phpisfun/projet_gestion_de_stock/articles/");
            break;
        case 'Acceder aux Categories' :
            header("Location: http://localhost/phpisfun/projet_gestion_de_stock/categories/");
            break;
        case 'Acceder aux Fournisseurs' :
            header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/");
            break;
        case 'Administration' :
            header("Location: http://localhost/phpisfun/Projet_gestion_de_stock/admin/");
        default : die("SUBISSION ERROR : NO POST");
    }
}