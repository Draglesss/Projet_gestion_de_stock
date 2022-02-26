<?php
require '../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fournisseurs</title>
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
    <link rel="stylesheet" href="fournisseurs_styles.css">
    <center>
    <h1>Gestion des fournisseurs</h1>
    <div class="container">
        <div class="border">
            <h2>Menu de Gestion des fournisseurs : </h2>
            <div class="extra">
                <form action="fournisseurs_menu_choice.php" method="POST">
                <input type="submit" name="choice" value="Ajouter">
                <input type="submit" name="choice" value="Modifier"  style="background-color:orange;color: black;">
                <input type="submit" name="choice" value="Supprimer"  style="background-color:red;">
                <input type="submit" name="choice" value="Chercher" style="background-color: #00bfff;color: black;">
                </form>
                <a href="http://localhost/phpisfun/Projet_gestion_de_stock/main_interface/"><button style="background-color:green;">Acceuil</button></a>
            </div>
        </div>
    </div>
    <h1>Fournisseurs registrés : </h1>
    <div class="border">
    <?php
    $counter = 0;
    $count = false;
    show_count : if ($count) {
        echo '<h3><b><u>Total : '.$counter.'</u></b></h3>';
        exit;
    }
    require '../Mysql_config.php';
    
    //* Fetching stored data
    $records = mysqli_query($db,"SELECT * 
                                 FROM fournisseur"); //* Fetch data from database
    if(mysqli_num_rows($records) != 0){
        echo '<table border="2">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>CIN</th>
            <th>Adresse</th>
            <th>Telephone</th>
            <th>Email</th>
            <th>Alter</th>
        </tr>';
    while($data = mysqli_fetch_array($records))
    {
        ?>
        <tr>
            <td><?= $data['ID_fournisseur']; ?></td>
            <td><?= $data['Nom']; ?></td>
            <td><?= $data['Prenom']; ?></td>
            <td><?= $data['CIN']; ?></td>
            <td><?= $data['Adresse']; ?></td>
            <td><?= $data['Telephone']; ?></td>
            <td><?= $data['Email']; ?></td>
            <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=delete&id='.$data['ID_fournisseur'].'"
                                    ><button style="background-color:red;">Supprimer</button></a>'; 
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=modifie&id='.$data['ID_fournisseur'].'"
                                    ><button style="background-color:orange;color: black;">Modifier</button></a>';
                      echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=articles&id='.$data['ID_fournisseur'].'"
                                    ><button>Articles par ce Fournisseur</button></a>';
            ?></td>
        </tr>
        <?php
            $counter++;}
            mysqli_close($db);
            $count = true;
            goto show_count;
        }else { mysqli_close($db);
                die('<p><b><u>Aucun fournisseur n\'a étè registré</u></b></p>');
            }
        ?>
        </table>
    </div>
</center>
</body>
</html>
