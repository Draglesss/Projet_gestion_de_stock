<?php
//! library of functions i made for this project
function param(string $goal, string $obj) : void { //* feed-back for forms treated inside the same file
    die('Entrez '.$obj.' pour '.$goal.'');
}
function alert(string $message) : void { //* feed-back as an alert() by the browser
    die("<script>alert('$message')</script>");
}
function succ(string $task, string $obj) : void { //* redirects to successeful.php while transmitting necessary info for feed-back
    if (isset($db))
        mysqli_close($db);
    header("Location: http://localhost/phpisfun/projet_gestion_de_stock/successful.php?task=$task&obj=$obj");
}
function unsucc(string $goal, $obj = NULL, $mat = NULL, $val = NULL) : void {
    if (isset($db))
        mysqli_close($db);
    header("Location: http://localhost/phpisfun/projet_gestion_de_stock/unsuccessful.php?goal=$goal&obj=$obj&mat=$mat&val=$val");
}
function redirect(string $ref = 'main') { //* to avoid the repeated use of header in all the scripts
    switch ($ref) {
        case 'main' : $ref = 'http://localhost/phpisfun/Projet_gestion_de_stock/main_interface/';
                      break;
        case 'index' : $ref = 'http://localhost/phpisfun/projet_gestion_de_stock/';
                       break;
        case 'admin' : $ref = 'http://localhost/phpisfun/Projet_gestion_de_stock/admin/';
                       break;
        case 'article' : $ref = 'http://localhost/phpisfun/projet_gestion_de_stock/articles/';
                         break;
        case 'categorie' : $ref = 'http://localhost/phpisfun/projet_gestion_de_stock/categories/';
                           break;
        case 'fournisseur' : $ref = 'http://localhost/phpisfun/projet_gestion_de_stock/fournisseurs/';
                             break;
        default : die('ERROR : REDIRECTION CRASH ref : '.$ref);
                  break;
    }
    header("Location: $ref");
}
function terminate() { //* terminates the session
    session_unset();
    redirect('index');
}
function logg($path, string $role, $id, string $action, string $obj = NULL, string $details = NULL) { 
    //* logs actions of users in a csv file
    $path = ($path == 'index') ? 'logs.csv' : '../../logs.csv';
    $file = fopen($path, "a+") or die("UNABLE TO LOG");
    $date = date("Y-m-d h:i:sa");
    switch ($action) {
        case 'in' : $log = $role.', '.$id.', logged in, '.$date.'';
                    break;
        case 'out' : $log = $role.', '.$id.', logged out, '.$date.'';
                     break;
        case 'modified nb' : $log = $role.', '.$id.', '.$action.', '.$obj.', '.$details.' ,'.$date;
                             break;
        default : $log = $role.', '.$id.', '.$action.', '.$obj.', '.$details.', '.$date;
    }
    fwrite($file,$log."\n");
    fclose($file) or die('ERROR : LOG FILE UNCLOSED');
}
