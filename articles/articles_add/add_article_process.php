<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])) {
    if($_POST['submit'] == 'Enregistrer') {
        require '../../Mysql_config.php'; //* contains DB connection config assets
        if($_POST['Reference'] != "") {
            $Reference = $_POST['Reference'];
            if ($_POST['Nom'] != "") {
                $Nom = $_POST['Nom'];
                $Description = $_POST['Description'];
                $Nombre_en_stock = ($_POST['Nombre_en_stock'] != "") ? $_POST['Nombre_en_stock'] : 0;
                $ID_categorie = $_POST['Categorie'];
                if ($ID_categorie != "") {
                    $ID_fournisseur = $_POST['Fournisseur'];
                    if($ID_fournisseur != "") {
                        //* Checking if an item with the same ID already exists 
                        $check = mysqli_query($db,"SELECT Reference
                                                    FROM article
                                                    WHERE Reference = $Reference");
                        if(mysqli_num_rows($check) == 0 ) {
                            $check = mysqli_query($db,"SELECT Reference
                                                        FROM article
                                                        WHERE Nom = '$Nom'");
                            if(mysqli_num_rows($check) == 0) {
                                //* Checking if a "fournisseur" with the ID_fournisseur entered exists
                                $check = mysqli_query($db,"SELECT ID_fournisseur
                                                            FROM fournisseur
                                                            WHERE ID_fournisseur = $ID_fournisseur;");
                                if(mysqli_num_rows($check) != 0 ) {
                                    //* Checking if a "categorie" with the ID_categorie entered exists
                                    $check = mysqli_query($db,"SELECT ID_categorie
                                                                FROM categorie
                                                                WHERE ID_categorie = $ID_categorie;");
                                    if(mysqli_num_rows($check) != 0 ) {
                                        //* if all checks pass then insertion is given green light
                                        //*Image insertion
                                        if ($_FILES['image']['name'] != '') {
                                            $allowedTypes = ['jpg', 'jpeg', 'gif', 'png'];
                                            $target_dir = "../images/";
                                            $type = explode("/",$_FILES["image"]["type"]);
                                            if(in_array($type[1],$allowedTypes)){
                                                $tailleMax = 4*1048576;
                                                if ($_FILES["image"]["size"] <= $tailleMax) {
                                                    $extension = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                                                    $path = $target_dir.uniqid('',true).'.'.$extension;
                                                    move_uploaded_file($_FILES["image"]["tmp_name"],$path) ? : unsucc('f');
                                                    $insert = mysqli_query($db,"INSERT INTO article(Reference, Nom, Description, Nombre_en_stock, ID_categorie, ID_fournisseur, Image)
                                                                                VALUES ($Reference, '$Nom', '$Description', '$Nombre_en_stock', '$ID_categorie', '$ID_fournisseur', '$path');");
                                                }else unsucc('s', 'une image avec une taille plus petite');
                                            }else unsucc('s', 'un fichier de type image');
                                        }else
                                            $insert = mysqli_query($db,"INSERT INTO article(Reference, Nom, Description, Nombre_en_stock, ID_categorie, ID_fournisseur, Image)
                                                                        VALUES ($Reference, '$Nom', '$Description', '$Nombre_en_stock', '$ID_categorie', '$ID_fournisseur', null);");
                                        if ($insert)
                                        {
                                            logg(null, $_SESSION['Role'], $_SESSION['ID'], 'added', 'article', $Reference);
                                            mysqli_close($db);
                                            succ('insert','article');
                                        }
                                        else
                                        {
                                            echo 'ERROR IN INSERTION : '.mysqli_error($db);
                                        }
                                    }else unsucc('n', 'categorie', 'ID', $ID_categorie);
                                }else unsucc('n', 'fournisseur', 'ID',$ID_fournisseur);
                            }else unsucc('y','article', 'Nom', $Nom);
                        }else unsucc('y','article', 'Référence', $Reference);
                    }else unsucc('s', 'fournisseur');
                }else unsucc('s', 'categorie');
            }else unsucc('s', 'Nom');
        }else unsucc('s', 'Référence');
    }
    elseif($_POST['submit'] == 'Retourner')
        redirect('article');
    elseif($_POST['submit'] == 'Acceuil')
        redirect();
}
?>
