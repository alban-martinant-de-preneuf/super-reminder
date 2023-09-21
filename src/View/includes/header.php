<?php if (isset($_SESSION['user'])) : ?>

    <link rel="stylesheet" href="/super-reminder/public/css/style.css">
    
        <nav>
            <span id="profil_btn"><a href="">Profil</a></span>
            <span id="todo_btn"><a href="">To do list</a></span>
            <span id="deco_btn"><a href="">Déconnection</a></span>
        </nav>
    </header>

    <h1> Welcome
        <b>
            <?php
            $user = unserialize($_SESSION['user']);
            $fullName = $user->getFirstname() . " " . $user->getLastname();
            echo $fullName;
            ?>
        </b>
    </h1>


<?php else : ?>

    <header>
        <nav>

            <span><a class="material-symbols-outlined">Home</a></button>
            <span><a id="get_login_form" class="material-symbols-outlined">Se connecter</a></span>
            <span><a id="get_register_form" class="material-symbols-outlined">Créer un compte</a></span>

        </nav>
 
        <img src="/super-reminder/public/img/todo3.gif" id="girl" alt="Home Gif" width="300" height="300">
        <h1>Welcome to super-reminder!</h1>
    </header>

<?php endif ?>


</body>

</html>