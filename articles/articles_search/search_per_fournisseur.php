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
    <center>
    <link rel="stylesheet" href="../articles_style.css">
        <h1><u>Formulaire de Recherche d'article</u></h1>
        <form action="search_per_fournisseur.php" method="POST">
            <div class="container">
                <div class="border">
                ID    : <input type="number" name="ID" placeholder="Inserez ID de fournisseur ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"'; 
                                                                                                         elseif(isset($_GET['id'])) echo 'value="'.$_GET['id'].'"'?>>  <br><br>
                Nom/Prenom : <input type="text" name="Nom_Prenom" placeholder="Inserez Nom ou Prenom de fournisseur ici" <?php if(isset($_POST['Nom_Prenom'])) echo 'value="'.$_POST['Nom_Prenom'].'"'; ?>> <br><br>
                <input type="submit" name="submit" value="Chercher" style="padding: 30px 70px;background-color: #1b93e4;color: black">
                <input type="submit" name="submit" class="return" value="Retourner">
                <input type="submit" name="submit" class="return" value="Acceuil">
                </div>
            </div>
        </form>
    <?php
    require '../../Mysql_config.php';
    if(!isset($_POST['submit']) && isset($_GET['id'])) {
        echo '<h1>Résultats : </h1><div class="border">';
        $ID = $_GET['id'];
        goto shortcut;
    }
    elseif (isset($_POST['submit'])) {
        $submit = $_POST['submit'];
        if ($submit == 'Chercher') {
            echo '<h1>Résultats : </h1><div class="border">';
            $count = false;
            show_count : if ($count) {
                echo '<h3><b><u>Total : '.$counter.'</u></b></h3>';
                exit;
            }
            $ID = $_POST['ID'];
            $Nom_Prenom = $_POST['Nom_Prenom'];
            if ($ID == '' && $Nom_Prenom == '')
                die('Entrez un des paramétres pour chercher');
            elseif ($ID != '' && $Nom_Prenom != '')
                die('Entrez un seul paramétres');
            else {
            if ($ID != '') {
                $ID = $_POST['ID'];
                logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', 'fournisseur : '.$ID);
                $Nom_Prenom = $_POST['Nom_Prenom'];
                if($ID == "" && $Nom_Prenom == "")
                    die('<h3><u>Entrez un des paramétres</u></h3>');
                elseif($ID != "" && $Nom_Prenom != "")
                    die('<h3><u>Entrez un seul paramétre</u></h3>');
                if($ID != "") {
                    shortcut : $check = mysqli_query($db,"SELECT *
                                                          FROM fournisseur
                                                          WHERE ID_fournisseur = $ID;");
                    if(mysqli_num_rows($check) != 0){
                        $query = mysqli_query($db,"SELECT *
                                                   FROM article
                                                   WHERE ID_fournisseur = $ID;");
                        if (mysqli_num_rows($query) != 0){
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
                            while ($data = mysqli_fetch_array($query)){
                                ?>
                                <tr>
                                    <td class="id"><?= $data['ID_article']; ?></td>
                                    <td><?= $data['Reference'];?></td>
                                    <td><?= $data['Nom']; ?></td>
                                    <td class="description"><?= $data['Description']; ?></td>
                                    <td><?= $data['Nombre_en_stock']; ?></td>
                                    <td class="image-container"><img class="image" src=<?php if($data['Image'] != null) echo '"../images/'.explode('/',$data['Image'])[2];
                                                                                else echo '"../images/Default_pic.png'; echo '" alt="'.$data['Description'].'"';?> </td>
                                    <td><?= $data['ID_categorie']; ?></td>
                                    <td><?= $data['ID_fournisseur']; ?></td>
                                    <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=delete&ref='.$data['Reference'].'"
                                                        ><button style="background-color: red;color: white;">Supprimer</button></a>'; 
                                            echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifie&ref='.$data['Reference'].'"
                                                            ><button style="background-color:orange;color: black;">Modifier</button></a>';
                                            echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifiestock&ref='.$data['Reference'].'"
                                                            ><button>Modifier le nombre en stock</button></a>';
                                    ?></td>
                                </tr>
                                <?php
                                    $counter++; }
                                    mysqli_close($db);
                                    $count = true;
                                    goto show_count;
                                }else die('Aucune article n\'est par le fournisseur avec ID de '. $ID);
                            }else die('Il n\'existe aucun Fournisseur avec ID de '.$ID);
                        }
            }elseif ($Nom_Prenom != '') {
                $exists = false;
                $ID_found = [];
                logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', 'fournisseur : '.$Nom_Prenom);
                $fournisseurs = mysqli_query($db,"SELECT Nom, Prenom, ID_fournisseur
                                                  FROM fournisseur;");
                if(mysqli_num_rows($fournisseurs) != 0) {
                    while($data = mysqli_fetch_array($fournisseurs)) {
                        if(str_contains($data['Nom'],$Nom_Prenom) || str_contains($data['Prenom'],$Nom_Prenom)) {
                            $exists = true;
                            array_push($ID_found, $data['ID_fournisseur']);
                        }
                    }
                    if ($exists) {
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
                        $articles = mysqli_query($db, "SELECT *
                                                        FROM article");
                        if(mysqli_num_rows($articles) != 0) {
                            while($records = mysqli_fetch_array($articles)) {
                                if (in_array($records['ID_fournisseur'], $ID_found)) {
                                    ?>
                                    <tr>
                                        <td class="id"><?= $records['ID_article']; ?></td>
                                        <td><?= $records['Reference']; ?></td>
                                        <td><?= $records['Nom']; ?></td>
                                        <td class="description"><?= $records['Description']; ?></td>
                                        <td><?= $records['Nombre_en_stock']; ?></td>
                                        <td class="image-container"><img class="image" src=<?php if($records['Image'] != null) echo '"../images/'.explode('/',$records['Image'])[2];
                                                                                else echo '"../images/Default_pic.png'; echo '" alt="'.$records['Description'].'"';?> </td>
                                        <td><?= $records['ID_categorie']; ?></td>
                                        <td><?= $records['ID_fournisseur']; ?></td>
                                        <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=delete&ref='.$records['Reference'].'"
                                                            ><button style="background-color: red;color: white;">Supprimer</button></a>'; 
                                                echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifie&ref='.$records['Reference'].'"
                                                                ><button style="background-color:orange;color: black;">Modifier</button></a>';
                                                echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifiestock&ref='.$records['Reference'].'"
                                                                ><button>Modifier le nombre en stock</button></a>';
                                        ?></td>
                                    </tr>
                                    <?php
                                    $counter++;
                                }
                            }
                        mysqli_close($db);
                        $count = true;
                        goto show_count;
                        }else die ('Le stock est vide');
                    }else die('Aucune article n\'est par le fournisseur avec Nom ou Prenom de '.$Nom_Prenom);
                }else die ('La list des Fournisseurs est vide');
            }
        }
    }elseif ($submit == 'Acceuil')
        redirect();
    elseif ($submit == 'Retourner'){
        if(isset($_GET['id']))
            redirect('fournisseur');
        else 
            redirect('article');
    }
}
?>
</center>
</body>
</html>