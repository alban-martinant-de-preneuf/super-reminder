      <!-- PHP: If user is connected ... -->
      <?php if (isset($_SESSION['user'])) { ?>

          <header>
              <nav>
                  <a href="profil.php">Profil</a>
                  <a href="todolist.php">To do list</a>
                  <a href="login.php?deco">Déconnection</a>

              </nav>
          </header>

          <!-- <main>
        <h1>Welcome <b><?php echo $user->getFirstName() . " " . $user->getLastName(); ?></b></h1>
    </main> -->


          <!-- PHP: If user is not connected ... -->
      <?php } else { ?>

          <header>
              <nav>

                  <button class="material-symbols-outlined">home</button>
                  <button id="get_login_form" class="material-symbols-outlined">Se connecter </button>
                  <button id="get_register_form" class="material-symbols-outlined">Créer un compte</button>

              </nav>
          </header>
          <img src="./images/todo3.gif" alt="Home Gif" width="300" height="300">

      <?php } ?>


      </body>

      </html>