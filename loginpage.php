<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        body{
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div>
        <div style='width: 180px;
                    border: 1px solid;
                    border-radius: 5px;
                    padding: 20px;'>
        <?php echo "<form action='./index.php$url' method='POST'>"; ?>
                Username:<br>
                <input type='text' name='user' style='margin: 5px 0px;'><br>
                Password:<br>
                <input type='password' name='password' style='margin: 5px 0px;'><br>
                <input type='submit' value='Login' style='margin:5px 6px 0px 124px'>
            </form>
        </div>
        <?php
        if($accessDenied){
            echo "<div style='width:218px;color:red;border:2px solid red;'>Benutzername oder Passwort sind nicht vorhanden</div>";
        }
        ?>
    </div>
</body>
</html>