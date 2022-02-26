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
    <link rel="stylesheet" href="../fournisseurs_styles.css">
    <center>
        <h1>Formulaire de Reherche de fournisseur</h1>
    <form action="search_fournisseur.php" method="post">
        <div class="container">
        <div class="border">
        <p>
            ID    : <input type="number" name="ID" placeholder="Inserez ID ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"'; ?>>  
            <input type="submit" name="submit" value="Chercher par ID" style="background-color: #1b93e4;color:black"><br><br>
        </p>
        <p>
            Nom/Prenom : <input type="text" name="Nom_Prenom" placeholder="Inserez Nom ou Prenom ici" <?php if(isset($_POST['Nom_Prenom'])) echo 'value="'.$_POST['Nom_Prenom'].'"'; ?>> 
            <input type="submit" name="submit" value="Chercher par Nom ou Prenom" style="background-color: #1b93e4;color:black"><br><br>
        </p>
        <p>
            CIN : <input type="text" name="CIN" placeholder="Inserez CIN ici" <?php if(isset($_POST['CIN'])) echo 'value="'.$_POST['CIN'].'"'; ?>> 
            <input type="submit" name="submit" value="Chercher par CIN" style="background-color: #1b93e4;color:black"><br><br> 
        </p>
            <input type="submit" name="submit" class="return" value="Retourner">
            <input type="submit" name="submit" class="return" value="Acceuil">
        </div>
    </form>
</div>
<?php
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    echo '<h1>Résultat :</h1><div class="border">';
    $count = false;
       show_count : if ($count) {
           echo '<h3><u>Total : '.$counter.'</u></h3>';
           exit;
       }
    $submit = $_POST['submit'];
    if($submit == 'Chercher par ID') {
        if($_POST['ID'] != "") {
            $ID = $_POST['ID'];
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'fournisseur', 'ID : '.$ID);
            $full = mysqli_query($db, "SELECT *
                                        FROM fournisseur
                                        WHERE ID_fournisseur = $ID;");
            if(mysqli_num_rows($full) > 0) {
                $counter = 0;
                    echo '    <table border="2">
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
                    while($data = mysqli_fetch_array($full)){
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
                                     ><button style="background-color: red">Supprimer</button></a>'; 
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=modifie&id='.$data['ID_fournisseur'].'"
                                        ><button style="background-color:orange;color:black;">Modifier</button></a>';
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=articles&id='.$data['ID_fournisseur'].'"
                                        ><button>Articles par ce Fournisseur</button></a>';
                ?></td>
            </tr>
            <?php
                $counter++; }
                mysqli_close($db);
                $count = true;
                goto show_count;
            }else die('Aucun Fournisseur n\'existe avec ID de '.$ID);
        }else die('Entrez une ID pour chercher');
    }elseif ($submit == 'Chercher par CIN') {
            $CIN = $_POST['CIN'];
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'fournisseur', 'CIN : '.$CIN);
            if($CIN != "") {
                $full = mysqli_query($db, "SELECT *
                                            FROM fournisseur
                                            WHERE CIN like '%$CIN%';");
                if(mysqli_num_rows($full) > 0) {
                $counter = 0;
                    echo '    <table border="2">
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
                    while($items = mysqli_fetch_array($full)) {
                        ?>
                    <tr>
                        <td><?= $items['ID_fournisseur']; ?></td>
                        <td><?= $items['Nom']; ?></td>
                        <td><?= $items['Prenom']; ?></td>
                        <td><?= $items['CIN']; ?></td>
                        <td><?= $items['Adresse']; ?></td>
                        <td><?= $items['Telephone']; ?></td>
                        <td><?= $items['Email']; ?></td>
                        <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=delete&id='.$items['ID_fournisseur'].'"
                                            ><button style="background-color: red">Supprimer</button></a>'; 
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=modifie&id='.$items['ID_fournisseur'].'"
                                            ><button style="background-color:orange;color:black;">Modifier</button></a>';
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=articles&id='.$items['ID_fournisseur'].'"
                                            ><button>Articles par ce Fournisseur</button></a>';
                        ?></td>
                    </tr>
            <?php
                $counter++; }
                mysqli_close($db);
                $count = true;
                goto show_count;
                }else die('Aucun Fournisseur n\'existe avec CIN de '.$CIN);
            }else die('Entrez une CIN pour chercher');
    }elseif($submit == 'Chercher par Nom ou Prenom') {
        $Nom_Prenom = $_POST['Nom_Prenom'];
        if($Nom_Prenom != "") {
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'fournisseur', 'Nom_Prenom : '.$Nom_Prenom);
            $exists = false;
            $full = mysqli_query($db, "SELECT *
                                       FROM fournisseur;");
            if(mysqli_num_rows($full) != 0) {
                while($data = mysqli_fetch_array($full)) {
                    if(str_contains($data['Nom'],$Nom_Prenom) || str_contains($data['Prenom'],$Nom_Prenom)) {
                        $exists = true; 
                    }
                }
                if($exists) {
                    $counter = 0;
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
                    $get = mysqli_query($db, "SELECT *
                                              FROM fournisseur;");
                    while($records = mysqli_fetch_array($get)) {
                        if(str_contains($records['Nom'],$Nom_Prenom) || str_contains($records['Prenom'],$Nom_Prenom)) {
                            ?>
                    <tr>
                        <td><?= $records['ID_fournisseur']; ?></td>
                        <td><?= $records['Nom']; ?></td>
                        <td><?= $records['Prenom']; ?></td>
                        <td><?= $records['CIN']; ?></td>
                        <td><?= $records['Adresse']; ?></td>
                        <td><?= $records['Telephone']; ?></td>
                        <td><?= $records['Email']; ?></td>
                        <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=delete&id='.$records['ID_fournisseur'].'"
                                            ><button style="background-color: red">Supprimer</button></a>'; 
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=modifie&id='.$records['ID_fournisseur'].'"
                                            ><button style="background-color:orange;color:black;">Modifier</button></a>';
                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/fournisseurs_alter.php?choice=articles&id='.$records['ID_fournisseur'].'"
                                            ><button>Articles par ce Fournisseur</button></a>';
                            ?></td>
                            </tr>
                            <?php
                             $counter++;
                        }
                    }
                    mysqli_close($db);
                    $count = true;
                    goto show_count;
                }else die('Aucun Fournisseur n\'existe avec Nom ou Prenom de '.$Nom_Prenom);
            }else die('Aucun Fournisseur n\'est enregistré');
        }else die('Entrez un Nom ou Prenom pour chercher');
    }elseif ($submit == 'Retourner')
        redirect('fournisseur');
     elseif ($submit == 'Retourner au Menu')
        redirect();
}
?>
    </center>
</body>
</html>