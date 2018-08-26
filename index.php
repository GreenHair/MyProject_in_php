<?php
require("datenbank.php");

if (isset($_COOKIE["logincookie"])) {
    setcookie("logincookie", "Logged in", time() + 1800);
/*   if(array_key_exists("einkommen",$_REQUEST)){
        require("einkommen.php");
    }elseif(array_key_exists("eintragen",$_REQUEST)){
        require("eintragen.php");
    }elseif(array_key_exists("suchen",$_REQUEST)){
        require("suchen.php");
    }elseif(array_key_exists("logout",$_REQUEST)){
        setcookie("logincookie","Logged in", time()-300);
        showLoginForm();
    }else{        
        require("uebersicht.php");
    } 
     */ showPage($db);
} else {
    if (isset($_POST["user"]) && isset($_POST["password"])) {
        $user = checkIfUserExsists($_POST["user"], $db);
        if ($user) {
            if (md5($_POST["password"]) == $user[0]["password"]) {
                setcookie("logincookie", "Logged in", time() + 1800);
               // require("uebersicht.php");
                showPage($db);
            } else {
                showLoginForm();
                echo "<div style='margin-left:auto;margin-right:auto;width:210;color:red;border:2px solid red;'>Benutzername oder Passwort sind nicht vorhanden</div>";
            }
        }
    } else {
        showLoginForm();
    }
}

function showLoginForm()
{
    echo "<div style='margin:auto;
                    margin-top:10%;
                    width: 180;
                    border: 1px solid;
                    border-radius: 5px;
                    padding: 20px;'>
        <form action='./index.php" . createURL($_REQUEST) . "' method='POST'>
            Username:<br>
            <input type='text' name='user' style='margin: 5px 0px;'><br>
            Password:<br>
            <input type='password' name='password' style='margin: 5px 0px;'><br>
            <input type='submit' value='Login' style='
                                                float: right;
                                                margin-top: 5px;
                                                margin-right: 6px;'>
        </form>
    </div>";
}

function showPage($db)
{
    if (array_key_exists("einkommen", $_REQUEST)) {
        require("einkommen.php");
    } elseif (array_key_exists("eintragen", $_REQUEST)) {
        require("eintragen.php");
    } elseif (array_key_exists("suchen", $_REQUEST)) {
        require("suchen.php");
    } elseif (array_key_exists("logout", $_REQUEST)) {
        setcookie("logincookie", "Logged in", time() - 300);
        showLoginForm();
    } else {
        require("uebersicht.php");
    }
}


function checkIfUserExsists($name, $db)
{
    $stmt = $db->prepare("SELECT * FROM users WHERE name = ?");
    $stmt->execute(array($name));
    $result = $stmt->fetchAll();
    return $result;
}

function createURL($request)
{
    $url = "";
    if (array_key_exists("Periode", $request)) {
        $url .= "?Periode=" . $request["Periode"];
    } elseif (array_key_exists("einkommen", $request)) {
        $url .= "?einkommen";
    } elseif (array_key_exists("eintragen", $request)) {
        $url .= "?eintragen";
    } elseif (array_key_exists("suchen", $request)) {
        $url .= "?suchen";
    }
    return $url;
}
?>