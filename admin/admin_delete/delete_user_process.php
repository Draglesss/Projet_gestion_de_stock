<?php
    require '../../library.php';
    session_start(); 
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
        terminate();
require '../../Mysql_config.php';

if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    goto skip;
}
if (isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    if ($submit == 'Supprimer') {
        $ID = $_POST['ID'];
        $Nom_prenom = $_POST['Nom_prenom'];
        if ($ID != "" && $Nom_prenom == "") {
        skip :  $check = mysqli_query($db," SELECT ID, Role
                                            FROM users
                                            WHERE ID = $ID;");
                $data = mysqli_fetch_array($check);
            if (mysqli_num_rows($check) != 0) {
                $delete = mysqli_query($db, "DELETE FROM users
                                             WHERE ID = $ID;");
                if ($delete)
                    logg(NULL, $_SESSION['Role'], $_SESSION['ID'], 'deleted', $data['Role'] , $ID);
                    succ('delete','user');
            }else unsucc('n','user','ID', $ID);
        }elseif ($Nom_prenom != "" && $ID == "") {
            $Nom_prenom = explode(" ", $Nom_prenom);
            $Nom = $Nom_prenom[0];
            $Prenom = $Nom_prenom[1];
            $check = mysqli_query($db," SELECT ID
                                        FROM users
                                        WHERE Nom = '$Nom' AND Prenom = '$Prenom';");
            $data = mysqli_fetch_array($check);
            if (mysqli_num_rows($check) != 0) {
                $delete = mysqli_query($db, "DELETE FROM users
                                             WHERE Nom = '$Nom' AND Prenom = '$Prenom';");
                if ($delete) {
                    logg(NULL, $_SESSION['Role'], $_SESSION['ID'], 'deleted', $data['Role'], $Nom.' '.$Prenom);
                    succ('delete','user');
                }
            }else unsucc('n','user','Nom et Prenom', "$Nom $Prenom");
        }elseif ($ID == "" && $_POST['Nom_prenom'] == "" || ($_POST['Nom_prenom'] != "" && $ID != "")) 
            unsucc('s', 'ID ou Nom et Prenom');
    }elseif ($submit == 'Retourner')
        redirect('admin');
    elseif ($submit == 'Quitter')
        redirect();
}else die("ERROR : NO POST");