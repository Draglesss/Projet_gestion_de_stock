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
    <title>Formulaire de suppression</title>
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
    <link rel="stylesheet" href="../categories_style.css">
<center>
<form action="delete_categorie_process.php" method="post">
    <h1>Formulaire de suppression d'une Categorie</h1>
    <div class="container">
    <div class="border">
     ID : <input type="number" name="ID" placeholder="Inserez ID ici"><br><br>
    OU<br><br>
    Nom : <input type="text" name="Nom" placeholder="Inserez Nom ici"> <br><br>
    ⚠ Tous les articles dans cette Catégorie vont êtres supprimés<br><br>
    <input type="submit" name="submit" value="Supprimer" style="padding: 30px 70px;background-color: red;">
    <input type="submit" name="submit" class="return" value="Retourner">
    <input type="submit" name="submit" class="return" value="Acceuil">
</div>
</form>
</div>
</center>
</body>
</html>