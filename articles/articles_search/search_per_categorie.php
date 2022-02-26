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
    <form action="search_per_categorie.php" method="POST">
        <h1><u>Formulaire de Recherche d'article</u></h1>
                <div class="container">
                    <div class="border">
                    ID    : <input type="number" name="ID" placeholder="Inserez ID de catégorie ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"';
                                                                                                    elseif(isset($_GET['id'])) echo 'value="'.$_GET['id'].'"';?>>  <br><br>
                    Nom/Description : <input type="text" name="Nom_desc" placeholder="Inserez Nom ou Description de catégorie ici" <?php if(isset($_POST['Nom_desc'])) echo 'value="'.$_POST['Nom_desc'].'"'; ?>> <br><br>
                    <input type="submit" name="submit" value="Chercher" style="padding: 30px 70px;background-color: #1b93e4;color: black">
                    <input type="submit" name="submit" class="return" value="Retourner">
                    <input type="submit" name="submit" class="return" value="Acceuil">
                    </form>
                    </div>
                </div>
        
        <br>
<?php
    require '../../Mysql_config.php';
if(isset($_GET['id']) && !isset($_POST['submit'])) {
        $ID = $_GET['id'];
        goto skip;
}
elseif(isset($_POST['submit'])) {
    $submit = $_POST['submit'];
    if ($submit == 'Chercher') {
       skip : echo '<h1>Résultat : </h1><div class="border">';
       $count = false;
       show_count : if ($count) {
           echo '<h3><b><u>Total : '.$counter.'</u></b></h3>';
           exit;
       }
       if(isset($_GET['id']) && !isset($_POST['submit']))
        goto skip2;
        $ID = $_POST['ID'];
        $Nom_desc = $_POST['Nom_desc'];
        if ($ID == "" && $Nom_desc == "")
            die('Entrez un des paramétres');
        elseif($ID != "" && $Nom_desc != "")
            die('Entrez un seul paramétre');
        skip2 : if ($ID != "") {
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', 'categorie : '.$ID);
            $check = mysqli_query($db,"SELECT *
                                        FROM categorie
                                        WHERE ID_categorie = $ID;");
            if (mysqli_num_rows($check) != 0) {
                $query = mysqli_query($db,"SELECT *
                                        FROM article
                                        WHERE ID_categorie = $ID;");
                if (mysqli_num_rows($query) != 0) {
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
                                     ><button style="background-color: red;">Supprimer</button></a>'; 
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
                }else die('Aucune article n\' est dans catégorie oú ID = '.$ID);
            }else die('Il n\' existe aucune Catégorie avec ID de '.$ID);
        }
        if($Nom_desc != "") {
            $ID_found = [];
            $exists = false;
            $Nom_desc = $_POST['Nom_desc'];
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'article', 'categorie : '.$Nom_desc);
            $categories = mysqli_query($db,"SELECT *
                                            FROM categorie;");
            if(mysqli_num_rows($categories) != 0) {
                while($data = mysqli_fetch_array($categories)) {
                    if(str_contains($data['Nom'],$Nom_desc) || str_contains($data['Description'],$Nom_desc)) {
                        $exists = true;
                        array_push($ID_found, $data['ID_categorie']);
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
                            if (in_array($records['ID_categorie'], $ID_found)) {
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
                    }else die ('Le stock est vide');
                }else die('Aucune article n\' est dans la categorie avec Nom ou Prenom de '.$Nom_desc);
            }else die ('La list des categories est vide');
        }
    }
    elseif ($submit == 'Retourner au Menu')
        redirect();
    elseif ($submit == 'Retourner'){
        if(isset($_GET['id']))
            redirect('categorie');
        else redirect('article');
    }
}
?>
</center>
</body>
</html>