<?php
require 'library.php';
session_start();
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_GET['task']) && isset($_GET['obj'])) {
     $task = $_GET['task'];
     $obj = $_GET['obj'];
     switch ($task) {
         case 'insert' : $task = 'Enregistré'; break;
         case 'delete' : $task = 'Supprimé'; break;
         case 'modifie' : $task = 'Modifié'; break;
         default : die('SUBMISSION ERROR : NO GET : TASK');
     }
     switch ($obj) {
         case 'article' : $obj = 'Article';
                          $href = 'articles/';
                          break;
         case 'categorie' : $obj = 'Categorie';
                            $href = 'categories/';
                            break;
         case 'fournisseur' : $obj = 'Fournisseur';
                              $href = 'fournisseurs/';
                              break;
         case 'user' : $obj = 'Utilisateur';
                        $href = 'admin/';
                        break;
         default : die('SUBMISSION ERROR : NO GET : OBJ');
     }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <center>
    <meta charset="UTF-8">
    <title>Completed Successfully</title>

</head>
<body>
    <link rel="stylesheet" href="succ_unsucc_style.css">
    <center>
        <div class="container">
            <div class="border">
                <div class="center">
                    <div class="title"> <?=$obj ?> a été bien <?= $task?>. </div><br><br><br><br>
                    <a href="http://localhost/phpisfun/projet_gestion_de_stock/<?= $href ?>"><button class="button">Retourner</button></a>
                </div>
            </div>
        </div>
    </center>
</body>
</html>