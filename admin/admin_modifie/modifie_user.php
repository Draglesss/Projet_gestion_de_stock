<?php
require '../../library.php';
session_start(); 
if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
    terminate();
require '../../Mysql_config.php';
if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    if ($submit == 'Enregistrer') {
        $ID = $_POST['ID'];
        $Nom = $_POST['Nom'];
        $Prenom = $_POST['Prenom'];
        $Login = $_POST['Login'];
        $Password = $_POST['password'];
        $Password_re = $_POST['password_re'];
        $Role = $_POST['role'];
        if ($ID != "") {
            if ($Nom != "") {
                if ($Prenom != "") {
                    if ($Login != "") {
                        if ($Password != "") {
                            if ($Password_re != "") {
                                if ($Password_re == $Password) {
                                    $check = mysqli_query($db, "SELECT ID, Role
                                                                FROM users
                                                                WHERE ID = $ID;");
                                    if (mysqli_num_rows($check) != 0) {
                                        $checkNomPrenom = mysqli_query($db, "SELECT ID
                                                                    FROM users
                                                                    WHERE Nom = '$Nom' AND Prenom = '$Prenom' AND ID != $ID;");
                                        if (mysqli_num_rows($checkNomPrenom) == 0) {
                                            $hashed_password = password_hash($Password, PASSWORD_BCRYPT);
                                            if ($hashed_password) {
                                                $data = mysqli_fetch_array($check);
                                                $modifie = mysqli_query($db, "UPDATE users
                                                                              SET Nom = '$Nom', Prenom = '$Prenom', Login = '$Login', Password = '$hashed_password', Role = '$Role'
                                                                              WHERE ID = $ID;");
                                                if ($modifie) {
                                                    logg(null,$_SESSION['Role'], $_SESSION['ID'], 'modified', $data['Role'], $ID);
                                                    succ('modifie', 'user');
                                                }
                                                else 
                                                    die('ERROR : UNSUCCESSFUL MODIFICATION');
                                            } else die('ERROR : HASHING FAILED');
                                        }else unsucc('y', 'user', 'Nom et Prenom', "$Nom $Prenom");
                                    } else unsucc('n', 'user', 'ID', $ID);
                                } else unsucc('u');
                            } else unsucc('s', 'Mots de passe de verification');
                        } else unsucc('s', 'Mots de passe');
                    } else unsucc('s', 'Login');
                } else unsucc('s', 'Prenom');
            } else unsucc('s', 'Nom');
        } else unsucc('s', 'ID');
    }elseif ($submit == 'Retourner')
        redirect('admin');
    elseif ($submit == 'Quitter')
        redirect();
}else die('ERROR : NO POST');