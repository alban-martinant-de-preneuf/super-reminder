<?php if (isset($_SESSION['user'])) : ?>

    <header>
        <nav>
            <a href="profil.php">Profil</a>
            <a href="todolist.php">To do list</a>
            <a href="login.php?deco">Déconnection</a>
        </nav>
    </header>

    <h1>Welcome
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

            <button class="material-symbols-outlined">home</button>
            <button id="get_login_form" class="material-symbols-outlined">Se connecter </button>
            <button id="get_register_form" class="material-symbols-outlined">Créer un compte</button>

        </nav>
    </header>

<?php endif ?>


</body>

</html>