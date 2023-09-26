<header>

    <nav>

        <div id="home_btn" class="header_element">
            <a href="/super-reminder" id="home_link">
                <i class="fa-solid fa-house"></i>
            </a>
        </div>

        <?php if (isset($_SESSION['user'])) : ?>
            <div id="todo_btn"><a href="">lists</a></div>
            <div id="deco_btn"><a href="">logout</a></div>

        <?php else : ?>
            <div id="get_login_form"><a href="">log in</a></div>
            <div id="get_register_form"><a href="">sign in</a></div>

        <?php endif ?>
    </nav>

</header>



</body>

</html>