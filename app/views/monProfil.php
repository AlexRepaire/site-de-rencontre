<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon profil</title>
    <link rel="stylesheet" href="../public/css/monProfil.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
</head>

<body>
    <div id="page_profil" class="scroll_bar">
        <div id="navigation">
            <ul>
                <li class="line-right"><button id="comptebtn">Paramètre du compte</button></li>
                <li class="line-right"><button id="recherchebtn">Paramètre de recherche</button></li>
                <li><button id="contactbtn">Contact Administrateur</button></li>
            </ul>
        </div>
        <div id="gestionProfil" class="margin">
            <h2>Paramètres du compte</h2>
            <div>
                <form action="" method="post">
                    <label for="file" class="label-file">Choisir une photo</label>
                    <input id="file" class="input-file" type="file" onchange="previewFile()">
                    <img src="" height="200" id="img" alt="Aperçu de l’image">

                    <input type="submit" value="Valider la photo de profil">
                </form>

                <form action="index.php?page=profil" method="post">
                    <label for="email">Mail</label>
                    <input type="text" name="mail" id="mail" value="<?= $mail ?>">

                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" value="<?= $password ?>">

                    <input type="submit" value="Modifier infos">
                </form>

                <form action="index.php?page=profil" method="post" id="deleteProfil">
                    <label for="deleteCompte">Pour supprimer votre comptre entrer votre mot de passe :</label>
                    <input type="password" name="delete" id="deleteCompte">
                    <input type="submit" value="Supprimer mon compte">
                </form>
            </div>
        </div>
        <div id="parametreDeRecherche" class="margin">
            <h2>Paramètres de recherche</h2>
            <form action="index.php?page=profil" method="post">
                <label for="genre">Recherche :</label>
                <select id="genre" name="genre">
                    <option><?= $genre ?></option>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>

                <label for="ageMin">Age min: </label>
                <input type="min" name="ageMin" id="ageMin" value="<?= $ageMin ?>">

                <label for="ageMax">Age max: </label>
                <input type="max" name="ageMax" id="ageMax" value="<?= $ageMax ?>">

                <input type="submit" value="Valider">
            </form>
        </div>
        <div id="contact" class="margin">
            <h2>Contact</h2>
            <p>Veuillez écrire votre probleme, l'administrateur répondras des que possible!</p>
            <form action="" method="post">
                <input type="text" name="textMessage" size="69" height="600px">
                <input type="submit" value="Valider">
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../public/script/param.js"></script>
</body>
</html>


