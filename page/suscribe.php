<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/suscribe.css">
    <title>Document</title>
</head>
<header>
    <h2 class="titleHead">imagerie ATL</h2>
</header>

<body>
    <h1>Inscription</h1>
    <div  class="alreadyInsc">
        <h2>déjà inscrit ?</h2>
        <a href="./login.php">Cliquez ici</a>
    </div>
    <div class="formContainer">
        <form action="" method="POST">
            <div class="inputContain">
                <label for="name">nom :</label>
                <input type="text" id="name" name="name">
            </div class="inputContain">
            <div class="inputContain">
                <label for="firstname">prenom :</label>
                <input type="text" id="firstname" name="firstname">
            </div>
            <div class="inputContain">
                <label for="mail">email:</label>
                <input type="email" id="mail" name="mail">
            </div>
            <div class="inputContain">
                <label for="password">mot de passe :</label>
                <input type="password" id="password" name="password">

            </div>
            <div>
                <button type="button" id="toggleButton" onclick="togglePasswordVisibility()">afficher le mot de passe</button>
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>
    <?php
    session_start();
    $errors = false;
    $jsonFile = "../bdd/user.json";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["name"]) || !Preg_match('/^[a-zA-ZÀ-ÿ\-]+(?:\s[a-zA-ZÀ-ÿ\-]+)*$/', $_POST["name"])) {
            echo "Nom non valide";
            $errors = true;
        }
        if (!isset($_POST["firstname"]) || !Preg_match('/^[a-zA-ZÀ-ÿ\-]+$/', $_POST["firstname"])) {
            echo "prenom non valide";
            $errors = true;
        }
        if (!isset($_POST["mail"]) || !Preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["mail"])) {
            echo "mail non valide";
            $errors = true;
        }
        if (!isset($_POST["password"]) || !Preg_match('/^(?=.*[0-9].*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{4,}$/', $_POST["password"])) {
            echo  "mot de passe non valide";
            $errors = true;
        }
        if (!$errors) {
            $jsonData = file_get_contents($jsonFile);  // recupere le json de mes users
            $users = json_decode($jsonData, true); // je decode le json en tableau associatif lisible par php
            $newUser = array(
                'name' => $_POST['name'],
                'firstname' => $_POST['firstname'],
                'mail' => $_POST['mail'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            );
            $users[] = $newUser;
            $jsonUpDated = json_encode($users, JSON_PRETTY_PRINT); // j'encode mon tableau en json
            file_put_contents($jsonFile, $jsonUpDated); //j'ecrit mon nouveau tableau dans mon fichier
            header("Location: ./login.php ");
        }
    }

    ?>

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