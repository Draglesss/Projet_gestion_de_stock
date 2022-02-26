<?php
require 'library.php';
session_start();
if (!isset($_SESSION['ID']))
    terminate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs</title>
    <link rel="stylesheet" href="admin/admin_style.css">
    <div class="navigation">
        <a class="signout" href="logout.php">
            <img <?php
            switch ($_SESSION['Role']) {
                case 'admin' : $src = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSjk0_XkA-wTB3lx2Q52LW07zU8b9EtQVrVUrY-UvPd_FDUFiMWN8hlLMWDNGjVMpuT8Rk&usqp=CAU';
                               break;
                case 'user' : $src = 'https://previews.123rf.com/images/vitechek/vitechek1907/vitechek190700199/126786791-user-login-or-authenticate-icon-human-person-symbol-vector.jpg';
                              break;
            }
            echo 'src="'.$src.'"'; ?> >
        <div class="logout"><?= $_SESSION['Name'] ?></div>
        </a>
    </div>
</head>
<body>
<center>
    <h1>Logs</h1>
    <div class="container">
        <div class="border">
            <div class="extra">
                <form action="logger.php" method="post">
                    ID : <input type="number" name="ID" placeholder="Inserez ID ici" <?php if(isset($_POST['ID'])) echo 'value="'.$_POST['ID'].'"';
                                                                                            elseif(isset($_GET['id'])) echo 'value="'.$_GET['id'].'"';?> ><br><br>
                    Nom et Prenom : <input type="text" placeholder="Inserez Nom et Prenom ici" name="Nom_Prenom" <?php if(isset($_POST['Nom_Prenom'])) echo 'value="'.$_POST['Nom_Prenom'].'"';?>style="margin-bottom:5%">
                    <input type="submit" name="submit" value="Log" style="padding: 30px 70px;">
                    <input type="submit" class="return"name="submit" value="Retourner">
                    <input  type="submit" class="return" name="submit" value="Quitter">
                </form>
            </div>
        </div>
    </div>
    <?php
    if (isset($_GET['id'])) {
        $ID = $_GET['id'];
        echo '<h1>Résultats</h1><div class="border">';
        goto skip;
    }
    elseif (isset($_POST['submit'])) {
        $submit = $_POST['submit'];
        if($submit == 'Log') {
            echo '<h1>Résultats</h1><div class="border">';
            $count = false;
            show_count : if ($count) {
                echo '<h3><b><u>Total : '.($count-1).'</u></b></h3>';
                exit;
            }
            if ($_POST['ID'] == "" && $_POST['Nom_Prenom'] == "")
                die('Entrez un des paramétres pour chercher');
            elseif ($_POST['ID'] != "" && $_POST['Nom_Prenom'] != "")
                die('Entrez un seul paramétres pour chercher');
            if ($_POST['Nom_Prenom'] != '') {
                require 'Mysql_config.php';
                $Nom_Prenom = $_POST['Nom_Prenom'];
                logg('index', $_SESSION['Role'], $_SESSION['ID'], 'logged', NULL, $Nom_Prenom);
                $Nom_prenom = explode(" ", $Nom_Prenom);
                $Part1 = $Nom_prenom[0];
                $Part2 = isset($Nom_prenom[1]) ? $Nom_prenom[1] : "";
                $info = mysqli_query($db, "SELECT ID
                                           FROM users
                                           WHERE Nom = '$Part1' AND Prenom = '$Part2';");
                if(mysqli_num_rows($info) == 0) {
                    $info = mysqli_query($db, "SELECT ID
                                                FROM users
                                                WHERE Nom = '$Part2' AND Prenom = '$Part1';");
                }
                if (mysqli_num_rows($info) != 0) {
                    $ID = mysqli_fetch_array($info);
                    mysqli_close($db);
                    $ID = $ID['ID'];
                    goto Nom_Prenom;
                }else die('Aucun utilisateur ou admin avec Nom ou Prenom de '.$Nom_Prenom.' n\'est enregistré');
            }
            elseif($_POST['ID'] != "") {
                $ID = $_POST['ID'];
                skip : logg('index', $_SESSION['Role'], $_SESSION['ID'], 'logged', NULL, $ID);
                Nom_Prenom : $row_count = 1;
                $array = array();
                //! log.csv fetching and treatment (csv into array)
                if (($handle = fopen("logs.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 100000, ",")) !== FALSE) {
                        $num = count($data);
                        $row_count++;
                        for ($c=0; $c < $num; $c++) {
                            if($data[1] == $ID)
                                array_push($array, $data);
                                break;
                        }
                    }
                    fclose($handle);
                }
                if (!empty($array)) {
                    echo '<table border="2" class="log">
                        <tr>
                            <th>Num</th>
                            <th>Role</th>
                            <th>ID</th>
                            <th>Action</th>
                            <th>Objet</th>
                            <th>info</th>
                            <th>Date</th>
                        </tr>';
                    $count = 1;
                    foreach($array as $line) {
                        if (!isset($line[4]))
                            $line[4] = NULL;
                        if (!isset($line[5]))
                            $line[5] = NULL;
                        if ($line[2] == ' logged in' || $line[2] == ' logged out') {
                            $line[5] = $line[3];
                            $line[4] = NULL;
                            $line[3] = NULL;
                        }
                        echo '<tr>
                                <td>'.$count.'</td>
                                <td>'.$line[0].'</td>'.
                                '<td>'.$line[1].'</td>'.
                                '<td>'.$line[2].'</td>'.
                                '<td>'.$line[3].'</td>'.
                                '<td>'.$line[4].'</td>
                                <td>'.$line[5].'</td>
                            </tr>';
                        $count++;
                    }
                    goto show_count;
                }else die('Aucune activité est registrés par l\'utilisateur avec ID de '.$ID);
            }
        }elseif ($submit == 'Quitter')
            redirect();
        elseif ($submit == 'Retourner')
            redirect('admin');
    }
    ?>
</body>
</html>