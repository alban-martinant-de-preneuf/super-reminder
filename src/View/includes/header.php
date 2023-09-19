

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=style.css href="ttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />

</head>
    <title><Header></Header></title>
</head>

<body>
    
        
<!-- PHP: If user is connected ... -->
<?php if($user->isConnected()) { ?>

    <header>
        <nav>
            <a href="profil.php">Profil</a>
            <a href="todolist.php">To do list</a>
            <a href="login.php?deco">Déconnection</a>
            
        </nav>
    </header>
    
    <main>
        <h1>Welcome <b><?php echo $user->getFirstName(). " " . $user->getLastName(); ?></b></h1>
    </main>

    


    <!-- PHP: If user is not connected ... -->
    <?php } else { ?>

    <header>
        <nav>
            <a href="index.php" active>
                <span class="material-symbols-outlined">home</span>
                <span>Accueil</span>
            </a>
            <a href="login.php">
                 <span class="material-symbols-outlined">how_to_reg</span>
                 <span>Se connecter </span>
         </a>

            <a href="register.php">
           
        <span class="material-symbols-outlined">app_registration</span>
        <span>Créer un compte</span>
    </a>
        </nav>
    </header>

    <main>
        <img src="./images/todo3.gif" alt="Home Gif" width="300" height="300">
        <h1></h1>
       
    </main>

    <?php } ?>  

 
</body>

</html>
