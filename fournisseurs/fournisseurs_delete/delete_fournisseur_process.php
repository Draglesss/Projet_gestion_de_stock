<?php
require '../../Mysql_config.php';
require '../../library.php';
if(isset($_GET['id']))
    goto shortcut;
if(isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    if($submit == 'Supprimer') {
        if(($_POST['ID'] == "" && $_POST['CIN'] == "") || 
        ($_POST['ID'] != "" && $_POST['CIN'] != ""))
                header("Location: http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_delete/delete_fournisseur.html");
        else {
            shortcut : if(isset($_POST['ID']))
                            $ID = $_POST['ID'];
                        else $ID = $_GET['id'];
                            $CIN = $_POST['CIN'];
            }
        if($ID != "") {
        //* Checking if a Categorie with the ID entered exists
        $check = mysqli_query($db,"SELECT ID_fournisseur
                                   FROM fournisseur
                                   WHERE ID_fournisseur = $ID;");
        if(mysqli_num_rows($check) != 0) {
            $delete = mysqli_query($db,"DELETE FROM fournisseur
                                        WHERE ID_fournisseur = $ID;");
            $param = 'ID : '.$ID;
        }
        else unsucc('n','fournisseur','ID',$ID);
        }
        elseif($CIN != "") { //* Checking if a categorie with the Name entered exists
            $check = mysqli_query($db,"SELECT CIN
                                    FROM fournisseur
                                    WHERE CIN = '$CIN';");
            if(mysqli_num_rows($check) != 0 ) {                  
                $delete = mysqli_query($db,"DELETE FROM fournisseur
                                            WHERE CIN = '$CIN';");
                $param = 'CIN : '.$CIN;
            }
            else unsucc('n','fournisseur','CIN',$CIN);
        }
        
        if($delete) //* If deletion was successful
        {
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'added', 'fournisseur', $param);
            mysqli_close($db); //* Close db connection represented by variable $db
            header("Location: http://localhost/phpisfun/projet_gestion_de_stock/successful.php?task=delete&obj=fournisseur");
            exit; //* End the script
        }
        else
        {
            echo mysqli_error($db); //* Echos error information
        }
    }
    elseif($submit == 'Retourner')
        redirect('fournisseur');
    elseif($submit == 'Retourner au Menu')
        redirect();
    else die('<h1><u>La suppression n\'a pas passé avec succés</u></h1>');
}
?>