<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de rencontre</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="../public/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
</head>

<body>
<div id="container">
    <div id="header">
        <div id="titre">
            <h2>LoveMeet</h2>
        </div>
        <div id="form">
            <form action="index.php?page=login" method="post">
                <label for="mail">Mail:</label>
                <input type="text" id="mail" name="mail" placeholder="mail" required>

                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" placeholder="mot de passe" required>

                <input type="submit" value="Connexion">
            </form>
        </div>
    </div>

    <div id="main">
        <h1>Matchez. Discutez. Faites des rencontres.</h1>
        <div>
            <a href="index.php?page=register">Inscription</a>
        </div>
    </div>
</div>
</body>
</html>