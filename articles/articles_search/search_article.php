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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chercher</title>
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
<form action="search_article.php" method="post">
    <h1>Formulaire de Recherche d'article</h1>
    <div class="container">
        <div class="border">
                Référence    : <input type="number" name="Reference" placeholder="Inserez Référence ici" <?php if(isset($_POST['Reference'])) echo 'value="'.$_POST['Reference'].'"'; ?>>  <br><br>
                <u><b>OU</b></u><br><br>
                Nom/Description : <input type="text" name="Nom_desc" placeholder="Inserez Nom ou Description ici" <?php if(isset($_POST['Nom_desc'])) echo 'value="'.$_POST['Nom_desc'].'"'; ?>> <br><br>
            <input type="submit" name="submit" value="Chercher"  style="padding: 30px 70px;background-color: #1b93e4;color: black">
            <input type="submit" name="submit" class="return" value="Retourner">
            <input type="submit" name="submit" class="return" value="Acceuil">
        </div>
    </div>
</form>
<?php
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    $submit = $_POST['submit'];
    if($submit == 'Chercher') {
        echo '<h1>Résultats : </h1><div class="border">';
        $count = false;
       show_count : if ($count) {
           echo '<h3><b><u>Total : '.$counter.'</u></b></h3>';
           exit;
        }
        if($_POST['Reference'] == "" && $_POST['Nom_desc'] == "")
            die('Entrez un des paramétres pour chercher');
        elseif($_POST['Reference'] != "" && $_POST['Nom_desc'] != "")
            die('Entrez un seul paramétres pour chercher');
        //* When user inputs ID as search methode
        if($_POST['Reference'] != "") {
            $Reference = $_POST['Reference'];
            logg(null, $_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', $Reference);
            $query = mysqli_query($db,"SELECT *
                                        FROM article
                                        WHERE Reference = $Reference;");
            if(mysqli_num_rows($query) != 0){
                $counter = 0;
                echo '<table border="2">
                <tr>
                    <th>ID</th>
                    <th>Référence</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Nombre en Stock</th>
                    <th>Image</th>
                    <th>Categorie</th>
                    <th>Fournisseur</th>
                    <th>Alter</th>
                </tr>';
                while($data = mysqli_fetch_array($query)){
                    ?>
                            <tr>
                                <td class="id"><?= $data['ID_article']; ?></td>
                                <td><?= $data['Reference']; ?></td>
                                <td><?= $data['Nom']; ?></td>
                                <td class="description"><?= $data['Description']; ?></td>
                                <td><?= $data['Nombre_en_stock']; ?></td>
                                <td class="image-container"><img class="image" src=<?php if($data['Image'] != null) echo '"../images/'.explode('/',$data['Image'])[2];
                                                                                else echo '"../images/Default_pic.png'; echo '" alt="'.$data['Description'].'"';?> </td>
                                <td><?= $data['ID_categorie']; ?></td>
                                <td><?= $data['ID_fournisseur']; ?></td>
                                <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=delete&ref='.$data['Reference'].'"
                                    ><button style="background-color: red;
                                    color: white";>Supprimer</button></a>'; 
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifie&ref='.$data['Reference'].'"
                                    ><button style="background-color:orange;color: black;">Modifier</button></a>';
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifiestock&ref='.$data['Reference'].'"
                                    ><button class="button_table">Modifier le nombre en stock</button></a>';
                                ?></td>
        </tr>
        <?php
            $counter++; }
            mysqli_close($db);
            $count = true;
            goto show_count;
            }else die('Aucune article avec Référence de '.$Reference.' n\' a étè trouvé');

        //* If user inputs Nom_desc as his search methode
        }elseif ($_POST['Nom_desc'] != "") {
            $exists = false;
            $Nom_desc = $_POST['Nom_desc'];
            logg(null, $_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', $Nom_desc);
            $full = mysqli_query($db,"SELECT *
                                        FROM article;");
            if(mysqli_num_rows($full) != 0) {
                while($data = mysqli_fetch_array($full)) {
                    if(str_contains($data['Nom'],$Nom_desc) || str_contains($data['Description'],$Nom_desc)) {
                        $exists = true;
                    }
                }
                if($exists) {
                    $counter = 0;
                    echo '    <table border="2">
                    <tr>
                        <th>ID</th>
                        <th>Référence</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Nombre en Stock</th>
                        <th>Image</th>
                        <th>Categorie</th>
                        <th>Fournisseur</th>
                        <th>Alter</th>
                    </tr>';
                    $get = mysqli_query($db,"SELECT *
                                            FROM article;");
                    while($records = mysqli_fetch_array($get)) {
                        if(str_contains($records['Nom'],$Nom_desc) || str_contains($records['Description'],$Nom_desc)) {
                            ?>
                            <tr>
                                <td class="id"><?= $records['ID_article']; ?></td>
                                <td><?= $records['Reference'];?></td>
                                <td><?= $records['Nom']; ?></td>
                                <td class="description"><?= $records['Description']; ?></td>
                                <td><?= $records['Nombre_en_stock']; ?></td>
                                <td class="image-container"><img class="image" src=<?php if($records['Image'] != null) echo '"../images/'.explode('/',$records['Image'])[2];
                                                                                else echo '"../images/Default_pic.png'; echo '" alt="'.$records['Description'].'"';?> </td>
                                <td><?= $records['ID_categorie']; ?></td>
                                <td><?= $records['ID_fournisseur']; ?></td>
                                <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=delete&ref='.$records['Reference'].'"
                                    ><button style="background-color: red;
                                    color: white";>Supprimer</button></a>'; 
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifie&ref='.$records['Reference'].'"
                                    ><button style="background-color:orange;color: black;">Modifier</button></a>';
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifiestock&ref='.$records['Reference'].'"
                                    ><button class="button_table">Modifier le nombre en stock</button></a>';
                                ?></td>
                            </tr>
                            <?php
                             $counter++;
                        }
                    }
                    mysqli_close($db);   
                    $count = true;
                    goto show_count;
                }else
                    die('<p><b><u>Aucune article avec Nom ou Description de '.$Nom_desc.' n\' existe dans le stock</u></b></p>');
            }else die('<p><b><u>Le stock est vide</u></b></p>');
        }
    }elseif ($submit == 'Retourner')
        redirect('article');
    elseif ($submit == 'Retourner au Menu')
        redirect();
}
?>
</center>
</body>
</html>