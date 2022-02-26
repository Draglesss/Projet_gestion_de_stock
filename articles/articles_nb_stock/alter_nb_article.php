<?php
require '../../library.php';
session_start(); 
if(!isset($_SESSION['ID']))
    terminate();
if(isset($_POST['submit'])){
    require '../../Mysql_config.php';
    $submit = $_POST['submit'];
    if($submit == 'Enregistrer') {
        if($_POST['Reference'] != "") {
            $Reference = $_POST['Reference'];
            if($_POST['Nombre_en_stock'] != "")
            $Nombre_en_stock = $_POST['Nombre_en_stock'];
            else unsucc('s', 'Nombre en stock');
            $check = mysqli_query($db,"SELECT *
                                        FROM article
                                        WHERE Reference = $Reference;");
            $data = mysqli_fetch_array($check);
            if(mysqli_num_rows($check) != 0){
                $alter = mysqli_query($db,"UPDATE article
                                           SET Nombre_en_stock = $Nombre_en_stock
                                           WHERE Reference = $Reference;");
                if($alter) {
                    logg(null,$_SESSION['Role'], $_SESSION['ID'], 'modified nb', 'article', $Reference, $data['Nombre_en_stock'].' -> '.$Nombre_en_stock);
                    succ('modifie', 'article');
                }else die('ERROR : UNSUCCESSFULL MODIFICATION');
            }else unsucc('n','article', 'Référence', $Reference);
        }else unsucc('s', 'Référence');
    }elseif($submit == 'Retourner')
        redirect('article');
    elseif($submit == 'Acceuil')
        redirect();
    else die('<h1><u>Submission error : Submit value lost</u></h1>');
}else die('<h1><u>Submission error : Unregistred Submit</u></h1>');