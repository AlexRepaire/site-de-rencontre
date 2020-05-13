<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" href="../public/css/admin.css">
    <meta name="viewport" content="width=device-width, user-scalable=no">
</head>

<body>
<div id="page_admin">
    <h1>Espace administrateur</h1>

    <div id="listeUsers" class="scroll_bar">
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail</th>
                    <th>Envoyer message</th>
                    <th>Supprimer utilisateur</th>
                    <th>Voir profil</th>
                </tr>
            </thead>
            <tbody>
                <?= $allUsers ?>
            </tbody>
        </table>

    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="../public/script/admin.js"></script>
</body>
</html>

