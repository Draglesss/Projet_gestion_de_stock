<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
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
    <meta charset="UTF-8">
    <title>Formulaire d'ajout</title>
</head>
<body>
    <link rel="stylesheet" href="../articles_style.css">
<center>
<div class="container">
    <form action="add_article_process.php" method="post" enctype="multipart/form-data">
    <h1>Formulaire d'Ajout d'une article</h1>
        <div class="border">
        Référence*    : <input type="number" name="Reference" placeholder="Inserez Référence ici"><br><br>
        Nom* : <input type="text" name="Nom" placeholder="Inserez Nom ici"> <br><br>
        Description  : <br><textarea name="Description"></textarea> <br><br>
        Nombre en stock : <input type="number" name="Nombre_en_stock"> <br><br>
        <label for="upload" class="custom-file-upload">Image :
            <input type="file" name="image" id="file-upload">
        </label><br><br>
        Categorie : <input type="number" name="Categorie" placeholder="Categorie doit existe déja"><br><br>
        Fournisseur : <input type="number" name="Fournisseur" placeholder="Fournisseur doit existe déja"><br><br>
        <input type="submit" name="submit" value="Enregistrer" style="padding: 30px 70px;"><br>
        <input type="submit" name="submit" class="return" value="Retourner"><br>
        <input type="submit" name="submit" class="return" value="Acceuil">
        </div>
    </form>
</center>
</body>
</html>