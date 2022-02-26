<!DOCTYPE html>
<?php
    require '../../library.php';
    session_start(); 
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
        terminate();
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de modification</title>
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
<center>
<link rel="stylesheet" href="../admin_style.css">
<link rel="stylesheet" href="../admin_add/add_style.css">
<form action="modifie_user.php" method="post">
    <h1>Formulaire de modification</h1><br><br>
    <?php 
    if(isset($_GET['id'])) {
        $ID = $_GET['id'];
        require '../../Mysql_config.php';
        $results = mysqli_query($db,"SELECT *
                                    FROM users
                                    WHERE ID = $ID");
        $data = mysqli_fetch_array($results);
    }
    ?>
    <div class="container">
        <div class="border">
            ID à modifier    : <input type="number" name="ID" placeholder="Inserez ID ici" <?php if(isset($_GET['id'])) echo 'value="'.$_GET['id'].'"' ?> >  <br><br>
        </div><br>
    <pre>PAR</pre><br>
    <div class="border">
        Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['Nom'].'"'; ?> > <br><br>
        Prenom*  : <br><input type="text" name="Prenom" placeholder="Inserez Prenom ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['Prenom'].'"'; ?> > <br><br>
        Login : <input type="text" name="Login" placeholder="Nouveau Login" <?php if(isset($_GET['id'])) echo 'value="'.$data['Login'].'"'; ?> ><br><br>
        Mots de passe : <input type="password" name="password" placeholder="Nouveau mots de passe">
        <input type="password" name="password_re" placeholder="Répetez le mots de passe"><br>
        Role : <div class="wrapper">
                        <input type="radio" name="role" id="option-1" value="admin" <?php if(isset($_GET['id'])) if($data['Role'] == 'admin') echo 'checked';?> >
                        <input type="radio" name="role" id="option-2" value="user" <?php if(isset($_GET['id'])) { if($data['Role'] == 'user') echo 'checked'; } else echo 'checked';?> >
                        <label for="option-1" class="option option-1">
                            <div class="dot"></div>
                            <span>Admin</span>
                        </label>
                        <label for="option-2" class="option option-2">
                            <div class="dot"></div>
                            <span>Utilisateur</span>
                        </label>
                </div><br>
        <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;background-color:orange;color:black;"><br>
        <input type="submit" name="submit" class="return" value="Retourner"><br>
        <input type="submit" name="submit" class="return" value="Quitter" style="background-color:green;">
        </div>
    </div>
</form>
</center>
</body>
</html>