<?php require '../../library.php';
    session_start(); 
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
        terminate();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter utilisateur</title>
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
    <link rel="stylesheet" href="add_style.css">
    <center>
        <div class="container">
        <form action="add_user_process.php" method="post">
            <h1>Formulaire d'Ajout d'un utilisateur</h1><br>
            <div class="border">
            Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici"> <br><br>
            Prenom* : <br><input type="text" name="Prenom" placeholder="Inserez Prenom ici"> <br><br>
            Login : <input type="text" name="Login"> <br><br>
            Mots de passe : <br><input type="password" name="Password"> <br>
                            <input type="password" name="Password_re" placeholder="Rentrez le mots de passe"> <br>
            Role :<div class="wrapper">
                    <input type="radio" name="role" id="option-1" value="admin">
                    <input type="radio" name="role" id="option-2" value="user" checked>
                    <label for="option-1" class="option option-1">
                        <div class="dot"></div>
                        <span>Admin</span>
                    </label>
                    <label for="option-2" class="option option-2">
                        <div class="dot"></div>
                        <span>Utilisateur</span>
                    </label>
                  </div>
            <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;"> <br>
            <input type="submit" name="submit" class="return" value="Retourner"> <br>
            <input type="submit" name="submit" class="return" value="Quitter" style="background-color:green;">
            </div>
        </form>
        </div>
    </center>
</body>
</html>