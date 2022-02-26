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
<center>
<link rel="stylesheet" href="../articles_style.css">
<form action="modifie_article.php" method="post" enctype="multipart/form-data">
    <h1>Formulaire de modification d'une article</h1>
    <?php
    require '../../Mysql_config.php';
    if (isset($_GET['ref'])) {
    $ref = $_GET['ref'];
    $results = mysqli_query($db,"SELECT *
                                FROM article
                                WHERE Reference = $ref");
    $data = mysqli_fetch_array($results);
    }
    ?>
    <div class="container">
    <div class="border">
    Référence à modifier    : <input type="number" name="ref_original" placeholder="Inserez Référence ici" <?php if(isset($_GET['ref'])) echo 'value="'.$_GET['ref'].'"' ?> >  <br><br>
    </div>
    <pre><u>PAR</u></pre>
    <div class="border">
    Référence*  : <input type="number" name="ref" placeholder="Inserez Référence ici" <?php if(isset($_GET['ref'])) echo 'value="'.$_GET['ref'].'"' ?> > <br><br>
    Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici" <?php if(isset($_GET['ref'])) echo 'value="'.$data['Nom'].'"'; ?> > <br><br>
    Description  : <br><textarea name="Description"><?php if(isset($_GET['ref'])) echo $data['Description']; ?></textarea> <br><br>
    Nombre en stock : <input type="number" name="Nombre_en_stock" <?php if(isset($_GET['ref'])) echo 'value="'.$data['Nombre_en_stock'].'"'; ?> > <br>
    <label for="image" class="custom-file-upload">Image :
        <input type="file" name="image" id="file-upload">
    </label><br><br>
    Categorie : <input type="number" name="Categorie" placeholder="doit exist dèja" <?php if(isset($_GET['ref'])) echo 'value="'.$data['ID_categorie'].'"'; ?> ><br><br>
    Fournisseur : <input type="number" name="Fournisseur" placeholder="doit exist dèja" <?php if(isset($_GET['ref'])) echo 'value="'.$data['ID_fournisseur'].'"'; ?> ><br><br>
    <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;background-color:orange;color:black;"><br>
    <input type="submit" name="submit" class="return" value="Retourner"><br>
    <input type="submit" name="submit" class="return" value="Acceuil">
    </div>
</div>
</form>
</center>
</body>
</html>