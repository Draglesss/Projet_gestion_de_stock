<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    if($_POST['submit'] == 'Enregistrer') {
        $Description = $_POST['Description'];
        $Nom = $_POST['Nom'];
        if($Nom != "") {
            $check = mysqli_query($db,"SELECT ID_categorie
                                        FROM categorie
                                        WHERE Nom = '$Nom';");
            if(mysqli_num_rows($check) == 0) {
                $insert = mysqli_query($db,"INSERT INTO categorie(Nom, Description)
                                            VALUES ('$Nom', '$Description');");
            }
            else unsucc('y', 'categorie','Nom', $Nom);
            if($insert)
            {
                mysqli_close($db);
                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'added', 'categorie', $Nom);
                succ('insert', 'categorie');
                exit;
            }
            else
            {
                echo mysqli_error($db);
            }
        }else unsucc('s', 'Nom');
    }
    elseif($_POST['submit'] == 'Retourner')
        redirect('categorie');
    elseif($_POST['submit'] == 'Retourner au Menu')
        redirect();
}
?>