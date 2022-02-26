<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'ajout</title>
    <div class="navigation">
        <a class="signout" href="../../logout.php">
            <img <?php
            switch ($_SESSION['Role']) {
                case 'admin' : $src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjk0_XkA-wTB3lx2Q52LW07zU8b9EtQVrVUrY-UvPd_FDUFiMWN8hlLMWDNGjVMpuT8Rk&usqp=CAU';
                                break;
                case 'user' : $src = 'https://previews.123rf.com/images/vitechek/vitechek1907/vitechek190700199/126786791-user-login-or-authenticate-icon-human-person-symbol-vector.jpg';
                                break;
            }
            echo 'src="'.$src.'"'; ?> >
        <div class="logout"><?= $_SESSION['Name']?></div>
        </a>
    </div>
</head>
<body>
    <link rel="stylesheet" href="../fournisseurs_styles.css">
    <center>
<form action="add_fournisseur_process.php" method="post">
    <h1>Formulaire d'Ajout d'un Fournisseur</h1>
    <div class="container">
        <div class="border">
            <br>
            Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici"> <br><br>
            Prenom*  : <input type="text" name="Prenom" placeholder="Inserez Prenom ici"> <br><br>
            CIN : <input type="text" name="CIN"> <br><br>
            Adresse : <input type="text" name="Adresse"><br><br>
            Telephone : <input type="number" name="Telephone"> <br><br>
            Email : <input type="text" name="Email"> <br><br>
            <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;">
            <input type="submit" name="submit" class="return" value="Retourner">
            <input type="submit" name="submit" class="return" value="Acceuil">
            </form>
        </div>
    </div>
</center>
</body>
</html>