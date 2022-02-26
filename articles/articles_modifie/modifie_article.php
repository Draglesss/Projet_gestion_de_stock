<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit']) || isset($_GET['id'])) {
    $submit = $_POST['submit'];
    if($submit == 'Enregistrer'){
        require '../../Mysql_config.php';
        if($_POST['ref'] != "") {
            $ref = $_POST['ref'];
            $Nombre_en_stock = 0;
            if($_POST['ref_original'] != "") {
                $ref_orig = $_POST['ref_original'];
                if($_POST['Nom'] != "") {
                    $Nom = $_POST['Nom'];
                    if($_POST['Categorie'] != "") {
                        $Categorie = $_POST['Categorie'];
                        if($_POST['Fournisseur'] != "") {
                            $Fournisseur = $_POST['Fournisseur'];
                            $Desc = $_POST['Description'];
                            if($Nombre_en_stock != "")
                                $Nombre_en_stock = $_POST['Nombre_en_stock'];
                            $check_ref_orig = mysqli_query($db, "SELECT *
                                                                FROM article
                                                                WHERE Reference = $ref_orig;");
                            if(mysqli_num_rows($check_ref_orig) != 0) {
                                $check_ref = mysqli_query($db, "SELECT *
                                                                FROM article
                                                                WHERE Reference = '$ref' AND Reference != $ref_orig;");
                                if ($check_ref == false) echo mysqli_error($db);
                                if(mysqli_num_rows($check_ref) == 0) {
                                    if ($_FILES['image']['name'] != '') {
                                        $allowedTypes = ['jpg', 'jpeg', 'gif', 'png'];
                                        $target_dir = "../images/";
                                        $type = explode("/",$_FILES["image"]["type"]);
                                        if(in_array($type[1],$allowedTypes)){
                                            $tailleMax = 4*1048576;
                                            if ($_FILES["image"]["size"] <= $tailleMax) {
                                                $query = mysqli_query($db, "SELECT Image
                                                                            FROM article
                                                                            WHERE Reference = $ref_orig;");
                                                if ($query == false) echo mysqli_error($db);
                                                $data = mysqli_fetch_array($query);
                                                $extension = pathinfo($_FILES["image"]["name"],PATHINFO_EXTENSION);
                                                $path = $target_dir.uniqid('',true).'.'.$extension;
                                                move_uploaded_file($_FILES["image"]["tmp_name"],$path);
                                                $modifie = mysqli_query($db,"UPDATE article
                                                                             SET Reference = $ref, Nom = '$Nom', Description = '$Desc', Nombre_en_stock = $Nombre_en_stock, ID_categorie = $Categorie, ID_fournisseur = $Fournisseur, Image = '$path'
                                                                             WHERE Reference = $ref;");
                                            }else unsucc('s', 'une image avec une taille plus petite');
                                        }else unsucc('s', 'un fichier de type image');
                                    }else
                                        $modifie = mysqli_query($db,"UPDATE article
                                                                     SET Reference = $ref, Nom = '$Nom', Description = '$Desc', Nombre_en_stock = $Nombre_en_stock, ID_categorie = $Categorie, ID_fournisseur = $Fournisseur, Image = null
                                                                     WHERE Reference = $ref;");
                                    if($modifie) {
                                        logg(null,$_SESSION['Role'], $_SESSION['ID'], 'modified', 'article', $ref_orig.' -> '.$ref);
                                        succ('modifie', 'article');
                                    }else die('ERROR : UNSUCCESSFUL MODIFICATION');
                                }else unsucc('y','article', 'Référence', $ref);
                            }else unsucc('n','article', 'Référence à modifier', $ref_orig);
                        }else unsucc('s','fournisseur');
                    }else unsucc('s','categorie');
                }else unsucc('s','nom');
            }else unsucc('s','Référence á modifié');
        }else unsucc('s','Référence');
    }elseif($_POST['submit'] == 'Retourner') 
        redirect('article');
    elseif($_POST['submit'] == 'Acceuil')
        redirect();
}