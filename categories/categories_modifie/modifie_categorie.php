<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    $submit = $_POST['submit'];
    if($submit == 'Enregistrer') {
        if($_POST['ID_original'] != "") {
            $ID_orig = $_POST['ID_original'];
                if($_POST['Nom'] != "") {
                    $Nom = $_POST['Nom'];
                    $Description = $_POST['Description'];
                    $check_ID_orig = mysqli_query($db, "SELECT *
                                                FROM categorie
                                                WHERE ID_categorie = $ID_orig;");
                    if(mysqli_num_rows($check_ID_orig) != 0) {
                            $update = mysqli_query($db, "UPDATE categorie
                                                        SET Nom = '$Nom', Description = '$Description'
                                                        WHERE ID_categorie = $ID_orig;");
                            if($update) {
                                mysqli_close($db);
                                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'modified', 'categorie', $ID_orig);
                                succ('modifie', 'categorie');
                            }else die('ERROR : FAILED MODIFICATION');
                    }else unsucc('n', 'categorie', 'ID', $ID_orig);
                }else unsucc('s', 'Nom', null, null);
        }else unsucc('s', 'ID á modifier', null, null);
    }elseif ($submit == 'Retourner')
        redirect('categorie');
    elseif($submit == 'Retourner au Menu')
        redirect();
}