<?php 
    require '../library.php';
    session_start();
    if(!isset($_SESSION['ID']))
        terminate();
    elseif ($_SESSION['Role'] != 'admin')
        unsucc('a', 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
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
    <link rel="stylesheet" href="admin_style.css">
    <center>
    <h1>Administration</h1>
    <div class="container">
        <div class="border">
        <h2>Menu de Gestion des utilisateurs : </h2>
            <div class="extra">
                <form action="admin_menu_choice.php" method="POST">
                    <input type="submit" name="choice" value="Ajouter">
                    <input type="submit" name="choice" value="Modifier" style="background-color:orange;color: black;">
                    <input type="submit" name="choice" value="Supprimer" style="background-color: red;color: white;">
                    <input type="submit" name="choice" value="Chercher" style="background-color: #00bfff;color: black;">
                    <input type="submit" name="choice" value="Logs" style="background-color: #00bfff;color: black;">
                </form>
            <a href="http://localhost/phpisfun/Projet_gestion_de_stock/main_interface/"><button style="background-color: green;">Quitter</button></a>
            </div>
        </div>
    </div>
    <h1>Utilisateurs registrés : </h1>
    <div class="border">
    <?php
    $count = false;
    show_count : if ($count) {
        echo '<h3><u>Total : '.$counter.'</u></h3>';
        exit;
    }
    require '../Mysql_config.php';
    //* Fetching stored data
    $users = mysqli_query($db,"SELECT * 
                                 FROM users"); //* Fetch data from database
    if(mysqli_num_rows($users) != 0) {
        $counter = 0;
        echo '<table border="2">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Role</th>
            <th class="smaller">Date de création</th>
            <th>Login</th>
            <th>Mots de passe</th>
            <th>Alter</th>
        </tr>';
    while($data = mysqli_fetch_array($users))
    {
        ?>
        <tr>
            <td><?= $data['ID']; ?></td>
            <td><?= $data['Nom']; ?></td>
            <td><?= $data['Prenom']; ?></td>
            <td><?= $data['Role'];?></td>
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
    } else { mysqli_close($db);
            die('Aucun utilisateur n\'est registré');
        }
        ?>
        </table>
    </div>
</center>
</body>
</html>