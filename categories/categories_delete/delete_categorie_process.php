<?php
include '../../Mysql_config.php';
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_GET['id']))
    goto shortcut;
if(isset($_POST['submit']) || isset($_GET['id'])) {
    $submit = $_POST['submit'];
    if($submit == 'Supprimer' || isset($_GET['id'])) {
    if(($_POST['ID'] == "" && $_POST['Nom'] == "") || 
       ($_POST['ID'] != "" && $_POST['Nom'] != ""))
            unsucc('s', 'ID ou Nom');
    else {
        shortcut : if(isset($_POST['ID']))
            $ID = $_POST['ID'];
        else $ID = $_GET['id'];
        $Nom = $_POST['Nom'];
    }
        if($ID != "") {
        //* Checking if a Categorie with the ID entered exists
        $check = mysqli_query($db,"SELECT ID_categorie
                                   FROM categorie
                                   WHERE ID_categorie = $ID;");
        $param = $ID;
        if(mysqli_num_rows($check) != 0)
            $delete = mysqli_query($db,"DELETE FROM categorie
                                        WHERE ID_categorie = $ID;");
        else unsucc('n','categorie','ID',$ID);
        }
        elseif($Nom != "") { //* Checking if a categorie with the Name entered exists
            $check = mysqli_query($db,"SELECT Nom
                                    FROM categorie
                                    WHERE Nom = '$Nom';");
            $param = $Nom;
            if(mysqli_num_rows($check) != 0 )                       
                $delete = mysqli_query($db,"DELETE FROM categorie
                                            WHERE Nom = '$Nom';");
            else unsucc('n', 'categorie', 'Nom', $Nom);
        }
    
        if($delete) //* If deletion was successful
        {
            mysqli_close($db); //* Close db connection represented by variable $db
            logg(null, $_SESSION['Role'], $_SESSION['ID'], 'deleted', 'categorie', $param);
            succ('delete', 'categorie');
            exit; //* End the script
        }
        else
        {
            echo mysqli_error($db); //* Echos error information
        }
    }
    elseif($submit == 'Retourner')
        redirect('categorie');
    elseif($submit == 'Retourner au Menu')
        redirect();
    else die('<h1><u>La suppression n\'a pas passé avec succés</u></h1>');
}
?>