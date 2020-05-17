<div id="page_profil">
    <div id="gestionProfil" class="margin">
        <h2>Paramètres du compte</h2>
        <div>
            <form action="index.php?page=upload" method="post" enctype="multipart/form-data">
                <label for="file" class="label-file">Choisir une photo</label>
                <input id="file" name="file" class="input-file" type="file">
                <img src="<?= $_SESSION['photo'] ?>" height="200" id="img" alt="Aperçu de l’image">

                <input type="submit" value="Valider la photo de profil">
            </form>

            <form action="index.php?page=updateProfilAdmin" method="post">
                <label for="email">Mail</label>
                <input type="text" name="mail" id="mail" value="<?= $mail ?>">


                <input type="submit" value="Modifier infos">
            </form>

            <form action="index.php?page=updatePasswordAdmin" method="post">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" name="password" id="password">

                <label for="password2">Entre encore votre nouveau mot de passe</label>
                <input type="password" name="password2" id="password2">

                <input type="submit" value="Modifier mot de passe">
            </form>

        </div>
    </div>
</div>

<!-- déplacer le script
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
-->