<?php 
require '../library.php';
session_start();
if(!isset($_SESSION['ID']))
    terminate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuil</title> 
    <div class="navigation">
        <a class="signout" href="../logout.php">
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
    <link rel="stylesheet" href="main_interface_style.css">
<body>
<center>
    <form action="../contact_POST.php" method="post">
        <div class="border">
            <div class="center">
                <input type="submit" name="choice" class="button" value="Acceder aux Articles">
                <input type="submit" name="choice" class="button" value="Acceder aux Categories">
                <input type="submit" name="choice" class="button" value="Acceder aux Fournisseurs">
                <input type="submit" name="choice" class="admin" value="Administration">
            </div>
        </div>
    </form>
</center>
</body>
</html>