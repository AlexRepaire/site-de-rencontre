<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de rencontre</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="../public/css/postRegister.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
</head>

<body>
<div id="main_container">
    <div id="container">

        <h1> Détail de votre profil</h1>
        <form method="post" action="index.php?page=postRegister">

            <div class="row">
                <label for="genre">Vous êtes :</label>
                <select name="genre" id="genre" required>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>

                <label for="nom"> Nom :</label>
                <input type="text" id="nom" name="nom" required>

                <label for="prenom">Prénom :</label>
                <input type="text" id="prenom" name="prenom" required>

                <label for="birthday">Date de naissance :</label>
                <input type="date" id="birthday" name="birthday" required>
            </div>

            <div class="row">
                <label for="adresse">Adresse :</label>
                <input type="text" id="adresse" name="adresse" required>

                <label for="ville">Ville </label>
                <input type="text" id="ville" name="ville" required>

                <label for="pays">Pays</label>
                <input type="text" id="pays" name="pays" required>

                <label for="bio">Description :</label>
                <input type="text" id="bio" name="description" required>
            </div>

            <div>
                <label for="genre">Vous recherchez :</label>
                <select name="genreMatch" id="genre" required>
                    <option value="homme">Homme</option>
                    <option value="femme">Femme</option>
                </select>

                <label for="ageMin">ageMin</label>
                <input type="number" name="ageMin">

                <label for="ageMax">ageMax</label>
                <input type="number" name="ageMax">

                <input type="submit" value="valider" id="valider">
            </div>

        </form>
    </div>
</div>

</body>
</html>