<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link rel="stylesheet" href="../public/css/monProfil.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
</head>


<body>
<div id="page_profil">

    <div id="gestionProfil" class="margin">
        <h2>Paramètres du compte</h2>
        <div>
            <form action="" method="post">
                <label for="file" class="label-file">Choisir une photo</label>
                <input id="file" class="input-file" type="file" onchange="previewFile()">
                <img src="" height="200" id="img" alt="Aperçu de l’image">

                <input type="submit" value="Valider la photo de profil">
            </form>

            <form action="index.php?page=updateProfilAdmin" method="post">
                <label for="email">Mail</label>
                <input type="text" name="mail" id="mail" value="<?= $mail ?>">

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password">

                <input type="submit" value="Modifier infos">
            </form>
            <form action="index.php?page=deleteProfil" method="post">
                <input type="submit" value="Supprimer mon compte">
            </form>
        </div>
    </div>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../public/script/paramAdmin.js"></script>
</body>
</html>
<!-- déplacer le script -->
<script>
    function previewFile() {
        var preview = document.getElementById('img');
        var file    = document.querySelector('input[type=file]').files[0];
        var reader  = new FileReader();

        reader.addEventListener("load", function () {
            preview.src = reader.result;
        }, false);

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
