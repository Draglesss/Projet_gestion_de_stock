<?php
    require '../../library.php';
    session_start(); 
    if($_SESSION['Role'] != 'admin' || !isset($_SESSION['ID']))
        terminate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de recherche</title>
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
    <link rel="stylesheet" href="../admin_style.css">
    <script>
        function show_hide() {
            var x = document.getElementById("disclaimer");
            if (x.style.display === "none") {
                x.style.display = "block";
            } else {
                x.style.display = "none";
            }
        }
    </script>
    <center>
        <form action="search_user.php" method="post">
           <h1>Formulaire de recherche d'un utilisateur</h1><br>
            <div class="container">
                <div class="border">
                    ID : <input type="number" name="ID" placeholder="Inserez ID ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"'; ?>><br><br>
                    <u> OU </u> <br><br>
                    Nom et Prenom : <input type="text" name="Nom_prenom" placeholder="Inserez Nom et Prenom ici" <?php if(isset($_POST['Nom_prenom'])) echo 'value="'.$_POST['Nom_prenom'].'"'; ?>> <br><br><br>
                    <input type="submit" name="submit" value="Chercher" style="padding: 30px 70px;background-color: #1b93e4;color: black">
                    <input type="submit" name="submit" class="return" value="Retourner">
                    <input type="submit" name="submit" class="return" value="Quitter" style="background-color:green;">
                </div>
            </div>
        </form>
<?php
require '../../Mysql_config.php';
function show($obj, $value) {
    require '../../Mysql_config.php';
    if ($obj == 'ID') {
        $query = mysqli_query($db, "SELECT *
                                    FROM users
                                    WHERE ID = $value;");
    }elseif ($obj == 'Nom_Prenom') {
        $obj = 'Nom et prénom';
        $Nom_prenom = explode(" ", $value);
        $Part1 = $Nom_prenom[0];
        $Part2 = isset($Nom_prenom[1]) ? $Nom_prenom[1] : "";
        $query = mysqli_query($db, "SELECT *
                                    FROM users
                                    WHERE Nom = '$Part1' AND Prenom = '$Part2';");
    }
        if (mysqli_num_rows($query) == 0) {
            $query = mysqli_query($db, "SELECT *
                                        FROM users
                                        WHERE Nom = '$Part2' AND Prenom = '$Part1';");
        }
    if (mysqli_num_rows($query) != 0) {
        $count = false;
        show_count : if($count) {
            die('<h3><u>Total : '.$counter.'</u></h3>');
        }
        $counter = 0;
        echo '<table border="2">
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de création</th>
                <th>Login</th>
                <th>Password</th>
                <th>Alter</th>
            </tr>';
            while ($data = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?= $data['ID']; ?></td>
                    <td><?= $data['Nom']; ?></td>
                    <td><?= $data['Prenom']; ?></td>
                    <td><?= $data['Date_de_creation']; ?></td>
                    <td><?= $data['Login']; ?></td>
                    <td><?= $data['Password']; ?></td>
                    <td class="alter-container"><?= '<a href="http://localhost/phpisfun/projet_gestion_de_stock/admin/users_alter.php?choice=delete&id='.$data['ID'].'"
                                            ><button style="background-color: red;color: white";>Supprimer</button></a>'; 
                            echo '<a href="http://localhost/phpisfun/projet_gestion_de_stock/admin/users_alter.php?choice=modifie&id='.$data['ID'].'"
                                            ><button style="background-color:orange;color: black;">Modifier</button></a>';
                            echo  '<a href="http://localhost/phpisfun/projet_gestion_de_stock/admin/users_alter.php?choice=log&id='.$data['ID'].'"
                                            ><button>Activités</button></a>';
                    ?></td>
                </tr>
                <?php
                $counter++;
            }
                mysqli_close($db);
                $count = true;
                goto show_count;
                } else die('Aucun utilisateur avec '.$obj.' de '.$value.' n\' a étè trouvé');
}
if (isset($_POST['submit'])) {
    echo '<h1><u>Résultat : </u></h1><div class="border">';
    $submit = $_POST['submit'];
    if ($submit == 'Chercher') {
        $ID = $_POST['ID'];
        $Nom_prenom = $_POST['Nom_prenom'];
        if (($ID == "" && $Nom_prenom == "") || ($ID != "" && $Nom_prenom != ""))
            param('chercher','ID ou Nom et Prenom');
        else {
            if ($ID != "") {
                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'searched', 'user', $ID);
                show('ID', $ID);
            }
            elseif ($Nom_prenom != "") {
                logg(null, $_SESSION['Role'], $_SESSION['ID'], 'searched', 'user', $Nom_prenom);
                show('Nom_Prenom', $Nom_prenom);
            }
        }
    }elseif ($submit == 'Retourner')
        redirect('admin');
    elseif ($submit == 'Quitter')
        redirect();
}
?>
    </center>
</body>
</html>