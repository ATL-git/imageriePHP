<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/home.css">
    <title>Document</title>
</head>
<header>
    <h2 class="titleHead">imagerie ATL</h2>
    <a class="deco" href="./logout.php">Déconnexion</a>

</header>

<body>

    <?php
    session_start();

    // Vérifier si l'utilisateur est connecté
    if (isset($_SESSION['user'])) {
        $userEmail = $_SESSION['user'];
        $pathJson = "../bdd/img.json";
        // Charger le contenu du fichier JSON
        $jsonData = file_get_contents('../bdd/img.json');

        // Convertir le JSON en tableau associatif
        $imageDataArray = json_decode($jsonData, true);

        // Vérifier si les données ont été récupérées avec succès
        if ($imageDataArray !== null) {
            // Afficher les images de l'utilisateur connecté
            echo "<h1>Bonjour  " . $_SESSION['name'] . "</h1>";
            echo "<p class='textHome'>Voici vos images : </p>";
            echo "<a class='addImg' href='./addimage.php'> --> Ajouter une image en cliquant ici <--</a>";

            foreach ($imageDataArray as $i => $imageData) {
                if ($imageData['mail'] === $userEmail) {
                    echo "<div class='imgContain'>";
                    echo "<div class='textContain'>";
                    echo "<p class='imgText'>" . $imageData['name'] . "</p>";
                    echo "<img src='" . $imageData['path'] . "' alt='" . $imageData['name'] . "' style='width: 600px;'>";
                    echo "<a class='linkDelete' href='?rmindex=$i'>supprimer</a>";
                    echo "</div>";
                    echo "</div>";
                    
                }
            }
        } else {
            echo "<p class='error'>Erreur : Impossible de charger les données des images.</p>";
        }

        // Vérifier si l'index de suppression est défini dans l'URL
        if (isset($_GET['rmindex'])) {
            $indexToRemove = $_GET['rmindex'];

            // Supprimer l'image correspondante du tableau
            unset($imageDataArray[$indexToRemove]);

            // Réorganiser les indices du tableau
            $imageDataArray = array_values($imageDataArray);

            // Réécrire le fichier JSON avec le tableau mis à jour
            $newJsonData = json_encode($imageDataArray, JSON_PRETTY_PRINT);
            file_put_contents($pathJson, $newJsonData);

            // Rediriger vers la même page pour actualiser la liste des images
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        // Rediriger l'utilisateur vers la page de connexion s'il n'est pas connecté
        header("Location: login.php");
        exit;
    }
    ?>


</body>
<footer>
    <p>Copyright ATL tous droit reserver</p>
</footer>

</html>