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

    <?php
    session_start();
    $errors = array(
        "name" => "",
        "firstname" => "",
        "mail" => "",
        "password" => ""
    );
    $jsonFile = "../bdd/user.json";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["name"]) || !preg_match('/^[a-zA-ZÀ-ÿ\-]+(?:\s[a-zA-ZÀ-ÿ\-]+)*$/', $_POST["name"])) {
            $errors["name"] = "Nom non valide";
        }
        if (!isset($_POST["firstname"]) || !preg_match('/^[a-zA-ZÀ-ÿ\-]+$/', $_POST["firstname"])) {
            $errors["firstname"] = "Prénom non valide";
        }
        if (!isset($_POST["mail"]) || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $_POST["mail"])) {
            $errors["mail"] = "Mail non valide";
        }
        if (!isset($_POST["password"]) || !preg_match('/^(?=.*[0-9].*[0-9])(?=.*[!@#$%^&*(),.?":{}|<>]).{4,}$/', $_POST["password"])) {
            $errors["password"] = "Mot de passe non valide";
        }

        // Vérifier s'il y a des erreurs
        $errorsExist = array_filter($errors);

        if (empty($errorsExist)) {
            // Traitement du formulaire si aucune erreur n'est détectée
            // Code pour enregistrer l'utilisateur dans le fichier JSON et rediriger vers la page de connexion
            $jsonData = file_get_contents($jsonFile);  // récupère le JSON des utilisateurs
            $users = json_decode($jsonData, true); // décode le JSON en tableau associatif
            $newUser = array(
                'name' => $_POST['name'],
                'firstname' => $_POST['firstname'],
                'mail' => $_POST['mail'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
            );
            $users[] = $newUser;
            $jsonUpdated = json_encode($users, JSON_PRETTY_PRINT); // encode le tableau en JSON
            file_put_contents($jsonFile, $jsonUpdated); // écrit le nouveau tableau dans le fichier
            header("Location: ./login.php ");
            exit;
        }
    }
    ?>

    <h1>Inscription</h1>
    <div class="alreadyInsc">
        <h2>déjà inscrit ?</h2>
        <a href="./login.php">Cliquez ici</a>
    </div>
    <div class="formContainer">
        <form action="" method="POST">
            <div class="inputContain">
                <label for="name">Nom :</label>
                <span class="error"><?php echo $errors["name"]; ?></span>
                <input type="text" id="name" name="name">

            </div>
            <div class="inputContain">
                <label for="firstname">Prénom :</label>
                <span class="error"><?php echo $errors["firstname"]; ?></span>
                <input type="text" id="firstname" name="firstname">

            </div>
            <div class="inputContain">
                <label for="mail">Email:</label>
                <span class="error"><?php echo $errors["mail"]; ?></span>
                <input type="email" id="mail" name="mail">

            </div>
            <div class="inputContain">
                <label for="password">Mot de passe :</label>
                <span class="error"><?php echo $errors["password"]; ?></span>
                <input type="password" id="password" name="password">

            </div>
            <div>
                <button type="button" id="toggleButton" onclick="togglePasswordVisibility()">Afficher le mot de passe</button>
                <button type="submit">Valider</button>
            </div>
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            let passwordInput = document.getElementById("password");
            let toggleButton = document.getElementById("toggleButton");
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