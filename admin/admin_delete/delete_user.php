<?php
    require '../../library.php';
    session_start(); 
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
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
<link rel="stylesheet" href="../admin_style.css">
<center>
<form action="delete_user_process.php" method="post">
    <h1>Formulaire de suppression d'un utilisateur</h1><br>
    <div class="container">
        <div class="border"> 
            ID : <input type="number" name="ID" placeholder="Inserez ID ici"><br><br>
            <u> OU </u> <br><br>
            Nom et Prenom : <input type="text" name="Nom_prenom" placeholder="Inserez Nom et Prenom ici"> <br><br><br>
            <input type="submit" name="submit" value="Supprimer" style="padding: 30px 70px;background-color: red;">
            <input type="submit" name="submit" class="return" value="Retourner">
            <input type="submit" name="submit" class="return" value="Quitter" style="background-color:green;">
        </div>
    </div>
</form>
</center>
</body>
</html>