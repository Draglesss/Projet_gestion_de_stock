<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
require '../../Mysql_config.php';
if(isset($_GET['ref']))
    goto skip;
if(isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    if($submit == 'Supprimer') {
        if(($_POST['Reference'] == "" && $_POST['Nom'] == "") || 
        ($_POST['Reference'] != "" && $_POST['Nom'] != ""))
                unsucc('s', 'Référence ou Nom');
        else {
            skip : if(isset($_POST['Reference']))
                        $Reference = $_POST['Reference'];
                else $Reference = $_GET['ref'];
                        $Nom = $_POST['Nom'];
        }
        if($Reference != "") {
            //* Checking if an Item with the ID entered exists
            $check = mysqli_query($db,"SELECT ID_article
                                        FROM article
                                        WHERE Reference = $Reference;");
            if(mysqli_num_rows($check) != 0) {
                $delete = mysqli_query($db,"DELETE FROM article
                                            WHERE Reference = $Reference;");
                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'deleted', 'article', $Reference);
            }
            else unsucc('n', 'article', 'Référence', $Reference);
        }
        elseif ($Nom != "") { //* Checking if an Item with the Name entered exists
            $check = mysqli_query($db,"SELECT Nom, ID_article
                                        FROM article
                                        WHERE Nom = '$Nom';");
            $data = mysqli_fetch_array($check);
            if(mysqli_num_rows($check) != 0 ) {
                $delete = mysqli_query($db,"DELETE FROM article
                                            WHERE Nom = '$Nom';");
                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'deleted', 'article', $data['ID_article']);
            }
            else unsucc('n','article', 'Nom', $Nom);
        }
        if($delete) //* If deletion was successful
        {
            mysqli_close($db); //* Close db connection represented by variable $db
            succ('delete', 'article');
            exit;
        }
        else
        {
            echo mysqli_error($db); //* Echos error information
        }
    }
    elseif($submit == 'Retourner')
        redirect('article');
    elseif($submit == 'Acceuil')
        redirect();
}
?>
