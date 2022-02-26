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
    <link rel="stylesheet" href="../fournisseurs_styles.css">
    <center>
<form action="modifie_fournisseur.php" method="post">
    <h1>Formulaire de modification d'un fournisseur</h1>
    <?php
    if (isset($_GET['id'])) {
        require '../../Mysql_config.php';
        $ID = $_GET['id'];
        $result = mysqli_query($db, "SELECT *
                                     FROM fournisseur
                                     WHERE ID_fournisseur = $ID");
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
    Prenom* : <input type="text" name="Prenom" placeholder="Inserez Prenom ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['Prenom'].'"'; ?> > <br><br>
    CIN*  : <input type="text" name="CIN" placeholder="Inserez CIN ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['CIN'].'"'; ?> > <br><br>
    Adresse : <input type="text" name="Adresse" placeholder="Inserez Adresse ici" <?php if(isset($_GET['id'])) echo 'value="'.$data['Adresse'].'"'; ?> > <br><br>
    Telephone : <input type="number" name="Telephone" <?php if(isset($_GET['id'])) echo 'value="'.$data['Telephone'].'"'; ?> > <br><br>
    Email : <input type="text" name="Email" <?php if(isset($_GET['id'])) echo 'value="'.$data['Email'].'"'; ?> > <br><br>
    <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;background-color:orange;color:black;">
    <input type="submit" name="submit" class="return" value="Retourner">
    <input type="submit" name="submit" class="return" value="Acceuil">
    </div>
</form>
</div>
</center>
</body>
</html>