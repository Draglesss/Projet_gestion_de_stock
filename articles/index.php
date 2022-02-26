<?php
require '../library.php';
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
    <title>Articles</title>
    <div class="navigation">
        <a class="signout" href="../logout.php">
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
    <link rel="stylesheet" href="articles_style.css">
    <center>
    <h1>Gestion des articles</h1>
    <div class="container">
        <div class="border">
            <div class="extra">
                <h2>Menu de Gestion des articles :</h2>
                <form action="articles_menu_choice.php" method="POST">
                    <input type="submit" name="choice" value="Ajouter">
                    <input type="submit" name="choice" value="Modifier" style="background-color:orange;color: black;">
                    <input type="submit" name="choice" value="Modifier le nombre en stock" style="background-color:orange;color: black;">
                    <input type="submit" name="choice" value="Supprimer" style="background-color: red;color: white;"><br><br>
                    <input type="submit" name="choice" value="Chercher" style="background-color: #00bfff;color: black;">
                    <input type="submit" name="choice" value="Chercher par Catégorie" style="background-color: #00bfff;color: black;">
                    <input type="submit" name="choice" value="Chercher par Fournisseur" style="background-color: #00bfff;color: black;">
                </form>
                <a href="http://localhost/phpisfun/Projet_gestion_de_stock/main_interface/"><button style="background-color: green;">Acceuil</button></a>
            </div>
        </div>
    </div>

        <br><br>
    <h1>Articles dans le stock : </h1>
    <div class="border">
    <?php
    $counter = 0;
    $count = false;
    show_count : if ($count) {
        echo '<h3><b><u>Total : '.$counter.'</u></b></h3>';
        exit;
    }
    //* Database Connection
    require '../Mysql_config.php';
    //* Fetching stored data
    $records = mysqli_query($db,"SELECT *
                                 FROM article"); //* Fetch data from database
    if(mysqli_num_rows($records) != 0) {
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
        while($data = mysqli_fetch_array($records))
        {
            ?>
            <tr>
                <td class="id"><?= $data['ID_article']; ?></td>
                <td><?= $data['Reference']; ?></td>
                <td><?= $data['Nom']; ?></td>
                <td class="description"><?= $data['Description']; ?></td>
                <td><?= $data['Nombre_en_stock']; ?></td>
                <td class="image-container"><img class="image" src=<?php if($data['Image'] != null) echo '"images/'.explode('/',$data['Image'])[2];
                                                                                else echo '"images/Default_pic.png'; echo '" alt="'.$data['Description'].'"';?> </td>
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
            $counter++;
        }
            mysqli_close($db);
            $count = true;
            goto show_count;
    } else { mysqli_close($db);
            die('Aucune article n\'est dans le stock');
        }
        ?>
</table>
    </div>
    </center>
</body>
</html>
