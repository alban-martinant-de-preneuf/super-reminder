<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="/super-reminder/public/css/style.css">
    <link rel="stylesheet" href="/super-reminder/public/css/todo.css">
    <link rel="stylesheet" href="/super-reminder/public/css/responsive.css">

    <script src="/super-reminder/public/js/script.js" defer></script>
    <script src="https://kit.fontawesome.com/247a482759.js" crossorigin="anonymous"></script>
    <title> Home Page | super-reminder</title>
</head>

<body>
    <?php require_once("includes/header.php"); ?>

    <div id="wrapper">

        <h1> Welcome
            <b>
                <?php
                if (isset($_SESSION['user'])) {
                    $user = unserialize($_SESSION['user']);
                    $fullName = $user->getFirstname() . " " . $user->getLastname();
                    echo $fullName;
                } else {
                    echo "to super-reminder";
                }
                ?>
            </b>
        </h1>
        
        <img src="/super-reminder/public/img/todo3.gif" id="girl" alt="Home Gif">

    </div>
</body>

</html>