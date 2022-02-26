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
<link rel="stylesheet" href="../articles_style.css">
<center>
<form action="alter_nb_article.php" method="post">
    <h1><u>Formulaire de modification d'une article</u></h1>
    <?php
    if (isset($_GET['ref'])) {
        require '../../Mysql_config.php';
        $ref = $_GET['ref'];
        $result = mysqli_query($db, "SELECT Nombre_en_stock
                                     FROM article
                                     WHERE Reference = $ref");
        $data = mysqli_fetch_array($result);
    }
    ?>
    <div class="container">
        <div class="border">
        Référence : <input type="number" name="Reference" placeholder="Inserez Référence ici" <?php if(isset($_GET['ref'])) echo 'value="'.$_GET['ref'].'"'; ?> >  <br><br>
        </div>
        <pre>PAR</pre>
        <div class="border">
        Nombre en stock : <input type="number" name="Nombre_en_stock" <?php if(isset($_GET['ref'])) echo 'value="'.$data['Nombre_en_stock'].'"'; ?> > <br><br>
        <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;background-color:orange;color:black;"><br>
        <input type="submit" name="submit" class="return" value="Retourner"><br>
        <input type="submit" name="submit" class="return" value="Acceuil">
        </div>
    </div>
</form>
</center>
</body>
</html>