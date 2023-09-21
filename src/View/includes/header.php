<?php if (isset($_SESSION['user'])) : ?>

    <header>
        <nav>
            <span id="profil_btn"><a href="">Profil</a></span>
            <span id="todo_btn"><a href="">To do list</a></span>
            <span id="deco_btn"><a href="">Déconnection</a></span>
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