<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/login.css">
    <title>Document</title>
</head>
<header>
    <h2 class="titleHead">imagerie ATL</h2>
</header>

<body>
    <h1>Login</h1>


    <?php
    session_start();
    $jsonFile = "../bdd/user.json";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['mail'])) {
            $jsonData = file_get_contents($jsonFile);
            $users = json_decode($jsonData, true);
            $foundUser = false;
            foreach ($users as $user) {
                if ($user['mail'] == $_POST['mail']) {
                    $foundUser = $user;
                    break;
                }
            }
            if ($foundUser != false) {
                if (password_verify($_POST['password'], $foundUser['password'])) {
                    $_SESSION['user'] = $foundUser['mail'];
                    $_SESSION['name'] = $foundUser['firstname'];
                    header('Location: ./home.php');
                    exit;
                } else {
                    echo ("<p class='error'>mot de passe incorrect</p>");
                }
            } else {
                echo ("<p class='error'>Aucun utilisateur trouver à ce nom</p>");
            }
        }
    }


    ?>

    <div class="formContainer">
        <form action="" method="POST">
            <div class="inputContain">
                <label for="mail">email:</label>
                <input type="email" id="mail" name="mail">
            </div>
            <div class="inputContain">
                <label for="password">mot de passe :</label>
                <input type="password" id="password" name="password">

            </div>
            <button type="button" id="toggleButton" onclick="togglePasswordVisibility()">afficher le mot de passe</button>
            <button type="submit">Valider</button>
            <div>
                <a class="suscribLink"href="./suscribe.php">S'inscrire ici</a>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleButton = document.getElementById("toggleButton");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = "Masquer le mot de passe";
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = "Afficher le mot de passe";
            }
        }
    </script>
</body>
<footer>
    <p>Copyright ATL tous droit reserver</p>
</footer>

</html>