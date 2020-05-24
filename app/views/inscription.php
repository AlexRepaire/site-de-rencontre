<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Site de rencontre</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="public/css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
</head>

<body>
    <div id="main_container">
        <div id="container">
            <h1>Inscription</h1>

            <form method="post" action="index.php?page=register">
                <label for="pseudo">Pseudo :</label>
                <input type="text" id="pseudo" name="pseudo" required>

                <label for="mail">Mail :</label>
                <input type="email" id="mail" name="mail" required>

                <label for="password"> mot de passe :</label>
                <input type="password" class="password" name="password" required>

                <label for="password"> répéter mot de passe :</label>
                <input type="password" class="password" name="password2" required>

                <input type="submit" value="valider" id="valider">
            </form>
        </div>
    </div>
</body>
</html>