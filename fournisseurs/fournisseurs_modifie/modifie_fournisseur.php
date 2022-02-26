<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    $submit = $_POST['submit'];
    if ($submit == 'Enregistrer') {
        if ($_POST['ID_original'] != "") {
            $ID_orig = $_POST['ID_original'];
                if ($_POST['Nom'] != "") {
                    $Nom = $_POST['Nom'];
                    if ($_POST['Prenom'] != "") {
                        $Prenom = $_POST['Prenom'];
                        if ($_POST['CIN'] != "") {
                            $CIN = $_POST['CIN'];
                            $Adresse = $_POST['Adresse'];
                            $Telephone = $_POST['Telephone'];
                            $Email = $_POST['Email'];
                            $check_ID_orig = mysqli_query($db, "SELECT *
                                                                FROM fournisseur
                                                                WHERE ID_fournisseur = $ID_orig;");
                            if(mysqli_num_rows($check_ID_orig) != 0) {
                                $update = mysqli_query($db, "UPDATE fournisseur
                                                            SET Nom = '$Nom',Prenom = '$Prenom', CIN = '$CIN', Adresse = '$Adresse', Telephone = '$Telephone', Email = '$Email'
                                                            WHERE ID_fournisseur = $ID_orig;");
                                if($update) {
                                    logg(null,$_SESSION['Role'], $_SESSION['ID'], 'modified', 'fournisseur', $ID_orig);
                                    mysqli_close($db);
                                    succ('modifie', 'fournisseur');
                                }else die('ERROR : UNSUCCESSFUL MODIFICATION');
                            }else unsucc('n','fournisseur','ID',$ID_orig);
                        }else unsucc('s','CIN');
                    }else unsucc('s','Prénom');
                }else unsucc('s','Nom');
        }else unsucc('s','ID à modifier');
    } elseif ($submit == 'Retourner')
        redirect('fournisseur');
     elseif($submit == 'Retourner au Menu')
        redirect();
}else die('SUBMISSION ERROR : NO SUBMIT');