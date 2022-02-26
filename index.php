<!--//? make a video
    //? organise css
-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login interface</title>
</head>
<body>
    <center style="text-align:center/left/right">
    <link rel="stylesheet" href="index_style.css">
    <!-- Login Form -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"/>
    <form action="index.php" method="post">
        <div class="container">
            <div class="border">
                <div class="title">Sign in</div><br><br>
                <input type="text" name="login" id="login" placeholder="login" <?php if(isset($_POST['login'])){ echo 'value="'.$_POST['login'].'"'; }?>><br>
                <input type="password" name="password" id="password" placeholder="password" <?php if(isset($_POST['password'])){ echo 'value="'.$_POST['password'].'"'; }?>>
                <i class="bi bi-eye-slash" id="togglePassword"></i><br><br>
                <input type="submit" class="button" name ="submit"value="Log In">
            </div>
        </div>
    </form>
    <script src="pass_hide.js"></script>
    <?php
    require 'library.php';
    if (isset($_POST['submit'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        if ($login != '') {
            if ($password != '') {
                require 'Mysql_config.php';
                $fetch = mysqli_query($db,"SELECT ID, Login, Password, Role, Prenom
                                           FROM users;");
                while($data = mysqli_fetch_array($fetch)) {
                    if ($login == $data['Login']) {
                        if (password_verify($password, $data['Password'])) {
                            session_start();
                            $_SESSION['ID'] = $data['ID'];
                            $_SESSION['Role'] = $data['Role'];
                            $_SESSION['Name'] = $data['Prenom'];
                            mysqli_close($db);
                            logg('index',$_SESSION['Role'], $_SESSION['ID'], 'in');
                            redirect();
                        }
                        alert('Mots de passe incorrecte');
                    }
                } 
                alert('Login et Mots de passe incorrectes');
            }else alert('Entrez un mots de passe');
        }else alert('Entrez un login');
    }
?>
</center>
</body>
</html>