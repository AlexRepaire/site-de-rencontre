<div id="page_profilUser">
    <h1>Utilisateur : <?= $res['nom'] ?> <?= $res['prenom']  ?></h1>
    <img src="" alt="">
    <p>Pseudo: <?= $res['pseudo'] ?></p>
    <p>Genre: <?= $res['genre'] ?></p>
    <p>Mail: <?= $res['mail'] ?></p>
    <p>Adresse: <?= $res['adresse'] ?></p>
    <p>Ville: <?= $res['ville'] ?></p>
    <p>Pays: <?= $res['pays'] ?></p>
    <p>Description: <?= $res['description'] ?></p>
    <p>Date de naissance: <?= $res['dateDeNaissance'] ?></p>
    <form action="index.php?page=contactUser" method="post">
        <input type="hidden" name="idUser" value="<?= $res['idUser'] ?>">
        <input type="text" name="textMessage">
        <input type="submit" value="Envoyer un message">
    </form>
    <form action="index.php?page=deleteUser" method="post">
        <input type="hidden" name="deleteUser" value="<?= $res['idUser'] ?>">
        <input type="submit" value="Supprimer l'utilisateur">
    </form>
</div>