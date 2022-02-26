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
<link rel="stylesheet" href="../categories_style.css">
<form action="search_categorie.php" method="post">
<h1>Formulaire de Recherche de catégorie</h1>
<div class="container">
    <div class="border">
            ID    : <input type="number" name="ID" placeholder="Inserez ID ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"'; ?>>  <br><br>
            Nom/Description : <input type="text" name="Nom_desc" placeholder="Inserez ID ici" <?php if(isset($_POST['Nom_desc'])) echo 'value="'.$_POST['Nom_desc'].'"'; ?>> <br><br>
        <input type="submit" name="submit" value="Chercher" style="padding: 30px 70px;background-color: #1b93e4;color: black">
        <input type="submit" name="submit" class="return" value="Retourner">
        <input type="submit" name="submit" class="return" value="Acceuil">
</div>
</form>
</div>
<?php
if(isset($_POST['submit'])) {
    require '../../Mysql_config.php';
    $submit = $_POST['submit'];
    if($submit == 'Chercher') {
        echo '<h1>Résultats :</h2><div class="border">';
            $count = false;
            show_count : if ($count) {
                echo '<h3><u>Total : '.$counter.'</u></h3>';
                exit;
            }
        if($_POST['ID'] == "" && $_POST['Nom_desc'] == "")
            die('Entrez un des paramétres');
        elseif($_POST['ID'] != "" && $_POST['Nom_desc'] != "")
            die('Entrez un seul paramétres');
        //* When user inputs ID as search methode
        if($_POST['ID'] != "") {
            $ID = $_POST['ID'];
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'categorie', $ID);
            $query = mysqli_query($db,"SELECT *
                                       FROM categorie
                                       WHERE ID_categorie = $ID;");
            if(mysqli_num_rows($query) != 0){
                $counter = 0;
                echo '<table border="2">
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Alter</th>
                </tr>';
                while($data = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?= $data['ID_categorie']; ?></td>
                        <td><?= $data['Nom']; ?></td>
                        <td><?= $data['Description']; ?></td>
                        <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_alter.php?choice=delete&id='.$data['ID_categorie'].'"
                                                ><button style="background-color: red;">Supprimer</button></a>'; 
                                echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_alter.php?choice=modifie&id='.$data['ID_categorie'].'"
                                                ><button style=";background-color: orange;color: black;">Modifier</button></a>';
                                echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/categories/categories_alter.php?choice=articles&id='.$data['ID_categorie'].'"
                                                ><button>Articles dans cette catégorie</button></a>';
                        ?></td>
                    </tr>
                    <?php
                    $counter++; 
                }
                mysqli_close($db);
                $count = true;
                goto show_count;
            }else die('Aucune article avec ID de '.$ID.' n\' a étè trouvé');
            //* If user inputs Nom_desc as his search methode
        }elseif ($_POST['Nom_desc'] != "") {
            $exists = false;
            $Nom_desc = $_POST['Nom_desc'];
            logg(null,$_SESSION['Role'], $_SESSION['ID'], 'searched', 'categorie', $Nom_desc);
            $full = mysqli_query($db,"SELECT *
                                      FROM categorie;");
            if(mysqli_num_rows($full) != 0) {
                while($data = mysqli_fetch_array($full)) {
                    if(str_contains($data['Nom'],$Nom_desc) || str_contains($data['Description'],$Nom_desc)) {
                        $exists = true;
                    }
                }
                if($exists) {
                    $counter = 0;
                    echo '<table border="2">
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Alter</th>
                    </tr>';
                    $get = mysqli_query($db,"SELECT *
                                             FROM categorie;");
                    while($records = mysqli_fetch_array($get)) {
                        if(str_contains($records['Nom'],$Nom_desc) || str_contains($records['Description'],$Nom_desc)) {
                            ?>
                            <tr>
                                <td><?= $records['ID_categorie']; ?></td>
                                <td><?= $records['Nom']; ?></td>
                                <td><?= $records['Description']; ?></td>
                                <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=delete&id='.$records['ID_categorie'].'"
                                                        ><button style="background-color: red;">Supprimer</button></a>'; 
                                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifie&id='.$records['ID_categorie'].'"
                                                        ><button style="background-color: orange;color: black;">Modifier</button></a>';
                                        echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/articles/articles_alter.php?choice=modifiestock&id='.$records['ID_categorie'].'"
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
                }else
                    die('Aucune article avec Nom ou Description de '.$Nom_desc.' n\' existe dans le stock');
            }die('Le stock est vide');
        }
    }elseif ($submit == 'Retourner')
        redirect('categorie');
    elseif ($submit == 'Retourner au Menu')
        redirect();
}
?>
</body>
</html>