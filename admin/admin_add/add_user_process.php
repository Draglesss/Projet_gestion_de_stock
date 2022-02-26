<?php
    require '../../library.php';
    session_start();
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
        terminate();
require '../../Mysql_config.php';
    if(isset($_POST['submit'])) {
        $submit = $_POST['submit'];
        if($submit == 'Enregistrer') {
            $Nom = $_POST['Nom'];
            if($Nom != "") {
                $Prenom = $_POST['Prenom'];
                if($Prenom != "") {
                    $login = $_POST['Login'];
                    if($login != "") {
                        $password = $_POST['Password'];
                        if($password != "") {
                            $password_re = $_POST['Password_re'];
                            if($password_re != "") {
                                if($password_re == $password) {
                                    $check = mysqli_query($db, "SELECT *
                                                            FROM users
                                                            WHERE Prenom = '$Prenom' AND Nom = '$Nom';");
                                    if(mysqli_num_rows($check) == 0) {
                                        $check = mysqli_query($db, "SELECT *
                                                                    FROM users
                                                                    WHERE Login = '$login';");
                                        if(mysqli_num_rows($check) == 0) {
                                            $role = $_POST['role'];
                                            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                                            if($hashed_password) {
                                                $ddc = date("Y-m-d");
                                                $insert = mysqli_query($db, "INSERT INTO users(Nom, Prenom, Date_de_creation , Login, Password, Role)
                                                                             VALUES ('$Nom', '$Prenom', '$ddc', '$login','$hashed_password', '$role');");
                                                if($insert) {
                                                    succ('insert','user');
                                                    logg(NULL,$_SESSION['Role'],$_SESSION['ID'], 'added', $role, $Nom.' '.$Prenom);
                                                }
                                                else
                                                    echo mysqli_error($db);
                                            } else alert('PASSWORD HASHING WAS UNSUCCESSFUL');
                                        } else unsucc('y','user','Login',$login);
                                    } else unsucc('y','user','Prenom et Nom',"$Prenom $Nom");
                                } else unsucc('u');
                            } else unsucc('s', 'Mots de passe de vérification');
                        } else unsucc('s','mots de passe');
                    } else unsucc('s','login');
                } else unsucc('s','prenom');
            } else unsucc('s','nom');
        } elseif($submit == 'Retourner') {
            redirect('admin');
        } elseif ($submit == 'Quitter')
        redirect();
    }
?>