<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/addimg.css">
    <title>Document</title>
</head>
<header>
    <h2 class="titleHead">imagerie ATL</h2>
    <a class="deco" href="./logout.php">Déconnexion</a>

</header>

<body>

    <a class="return" href="./home.php">Retour</a>

    <h1>Ajouter une Image :</h1>



    <?php
    session_start();
    if (isset($_SESSION['user'])) {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            if (empty($_POST['name'])) {
                echo "<p class='error'>Erreur : veuillez fournir un nom pour l'image</p>";
            } else {
                if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {

                    $fileTmpPath = $_FILES['img']['tmp_name'];
                    $fileName = $_FILES['img']['name'];
                    $fileSize = $_FILES['img']['size'];
                    $fileType = $_FILES['img']['type'];

                    $allowedTypes = array('image/jpeg', 'image/png', 'image/gif');
                    if (!in_array($fileType, $allowedTypes)) {
                        echo "<p class='error'>Erreur : Seuls les fichiers JPEG, PNG et GIF sont autorisés.</p>";
                        exit;
                    }

                    $uploadDir = '../assets/img/';
                    $destination = $uploadDir . $fileName;

                    if (move_uploaded_file($fileTmpPath, $destination)) {
                       
                        $fileInfo = array(
                            "name" => $_POST['name'],
                            "path" => $destination,
                            "mail" => $_SESSION['user']
                        );

                        $jsonData = file_get_contents("../bdd/img.json");
                        $data = json_decode($jsonData, true);


                        $data[] = $fileInfo;

                        $newJsonData = json_encode($data, JSON_PRETTY_PRINT);

                        file_put_contents("../bdd/img.json", $newJsonData);

                        header("Location: ./home.php");
                        exit;
                    } else {
                        echo "<p class='error'>Erreur lors du téléchargement du fichier.</p>";
                    }
                } else {
                    echo "<p class='error'>Erreur : Aucun fichier n'a été téléchargé ou une erreur est survenue lors du téléchargement.</p>";
                }
            }
        } 
    }else {
        header("Location: ./login.php");
        exit;
    }
    ?>

    <div class="formContainer">
        <form action="" method="POST" enctype="multipart/form-data">
            <div>
                <label for="name">nom :</label>
                <input type="text" id="name" name="name">
            </div>
            <div>
                <label for="img">rajouter votre image :</label>
                <input type="file" id="img" name="img">
            </div>
            <button type="submit">Valider</button>
        </form>
    </div>
</body>
<footer>
    <p>Copyright ATL tous droit reserver</p>
</footer>

</html>