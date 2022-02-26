<?php 
    require 'library.php';
    session_start();
    if(!isset($_SESSION['ID']))
        terminate();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unsuccessful</title>
</head>
<body>
    <link rel="stylesheet" href="succ_unsucc_style.css">
<center>
<?php
        $goal = $_GET['goal']; //* exists or !exists or uninserted
        $obj = $_GET['obj']; //* article, categorie, or fournisseur
        $matter = $_GET['mat']; //* ID, Nom, Prenom ...
        $value = $_GET['val']; //* matter's value
        switch ($obj) {
            case 'article' : $color = '#1b93e4';
                             $french_y = 'Une';
                             $french_n = 'Aucune';
                             break;
            case 'categorie' :$color = '#ff0000';
                              $french_y = 'Une';
                              $french_n = 'Aucune';
                              break;
            case 'fournisseur' : $color = '#008000';
                                 $french_y = 'Un';
                                 $french_n = 'Aucun';
                                 break;
            case 'user' : $obj = 'Utilisateur';
                          $color = 'white';
                          $french_y = 'Un';
                          $french_n = 'Aucun';
                          break;
            case 'admin' : $color = '#ee2929';
                            break;
            default : $color = 'white';
                      break;
        }
        ?>
    <div class="container">
        <div class="border">
               <div class="title"> <?php
                switch ($goal) {
                    case 'y' : echo ( $french_y.' '.$obj.' avec '.$matter.' de '.$value.' éxiste déja');
                               break;
                    case 'n' : echo ( $french_n.' '.$obj. ' n\'existe avec '.$matter.' de '.$value);
                               break;
                    case 's' : echo ('Veuillez saisir '.$obj);
                               break;
                    case 'u' : echo 'Les mots de passe ne sont pas identiques';
                               break;
                    case 'a' : echo 'Vous n\'avez pas le droit pour accéder à l\'administration';
                               break;
                    case 'f' : echo 'L\'envoie d\'image n\'a pas passé avec succés';
                               break;
                }
            ?></div><br><br>
            <button class="button" onclick="history.back()">Retourner</button>
            </div>
    </div>
</body>
</html>