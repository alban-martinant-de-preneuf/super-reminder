<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=style.css href="ttps://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="public/script.js" defer></script>



</head>
<body>
    <header>
        <h1>Register Form</h1>
    </header>

    <div id="registerForm">
        <label for="registerFirstName">Name</label>
        <input name="firstName" type="text" id="registerFirstName" placeholder="Enter your name"><br><br>

        <label for="registerLasttName">Last name</label>
        <input name="lastName" type="text" id="registerLasttName" placeholder="Enter your lastname"><br><br>

        <label for="registerEmail">Email</label>
        <input name="email" type="text" id="registerEmail" placeholder="Enter your email"><br><br>


        <label for="registerPassword">Password:</label>
        <input name="password" type="password" id="registerPassword" placeholder="Enter your password"><br><br>

        <label for="passwordComfirmation">Password:</label>
        <input name="password" type="password" id="passwordComfirmation" placeholder="Comfirme your password"><br><br>


        <button onclick="register()">Register</button>
    </div>

  
</body>
</html>
