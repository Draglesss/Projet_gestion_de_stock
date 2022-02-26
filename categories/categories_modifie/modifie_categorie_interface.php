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
    <link rel="stylesheet" href="../categories_style.css">
<center>
<form action="modifie_categorie.php" method="post">
   <h1>Formulaire de modification d'une catégorie</h1>
   <?php 
   if (isset($_GET['id'])) {
       require '../../Mysql_config.php';
       $ID = $_GET['id'];
       $result = mysqli_query($db, "SELECT *
                                    FROM categorie
                                    WHERE ID_categorie = $ID");
        $data = mysqli_fetch_array($result);
   }
   ?>
    <div class="container">
    <div class="border">
    ID à modifier    : <input type="number" name="ID_original" placeholder="Inserez ID ici" <?php if(isset($_GET['id'])) echo 'value="'.$_GET['id'].'"' ?> >  <br><br>
    </div>
    <pre>PAR</pre>
    <div class="border">
    Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['Nom'].'"'; ?> > <br><br>
    Description  : <br><textarea name="Description"><?php if(isset($_GET['id'])) echo $data['Description']; ?> </textarea> <br><br>
    <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;background-color:orange;color:black;">
    <input type="submit" name="submit" class="return" value="Retourner">
    <input type="submit" name="submit" class="return" value="Acceuil">
</div>
</form>
</center>
</body>
</html>