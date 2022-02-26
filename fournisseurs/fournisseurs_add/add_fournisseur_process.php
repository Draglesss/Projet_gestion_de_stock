<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Enregistrer') {
        require '../../Mysql_config.php'; //* contains DB connection config assets
        if ($_POST['Nom'] != "") {
            $Nom = $_POST['Nom'];
            if ($_POST['Prenom'] != "") {
                $Prenom = $_POST['Prenom'];
                if ($_POST['CIN'] != "") {
                    $CIN = $_POST['CIN'];
                    if (strlen($CIN) > 10)
                        unsucc('s', 'CIN correcte');
                    $Adresse = $_POST['Adresse'];
                    $Telephone = $_POST['Telephone'];
                    $Email = $_POST['Email'];
                     //* Checking if a fournisseur with the same ID already exists 
                    $check = mysqli_query($db,"SELECT ID_fournisseur
                                                FROM fournisseur
                                                WHERE Nom = '$Nom' AND Prenom = '$Prenom';");
                    if(mysqli_num_rows($check) == 0) {
                        $check =  mysqli_query($db,"SELECT ID_fournisseur
                                                    FROM fournisseur
                                                    WHERE CIN = '$CIN';");
                        if(mysqli_num_rows($check) == 0) {
                        //* if all checks pass then insertion is given green light
                            $insert = mysqli_query($db,"INSERT INTO fournisseur(Nom, Prenom, CIN, Adresse, Telephone, Email)
                                                        VALUES ('$Nom', '$Prenom', '$CIN', '$Adresse', '$Telephone', '$Email');");
                            if($insert) {
                                logg(null,$_SESSION['Role'], $_SESSION['ID'], 'added', 'fournisseur', $Nom.' '.$Prenom);
                                mysqli_close($db);
                                succ('insert','fournisseur');
                            }
                            else
                                {
                                echo mysqli_error($db);
                                }
                        }else unsucc('y','fournisseur', 'CIN', $CIN);
                    }else unsucc('y', 'fournisseur', 'Nom', $Nom);
                }else unsucc('s', 'CIN');
            }else unsucc('s', 'Prénom');
        }else unsucc('s', 'Nom');
    }
    elseif($_POST['submit'] == 'Retourner')
        redirect('fournisseur');
    elseif($_POST['submit'] == 'Retourner au Menu')
        redirect();
}
?>