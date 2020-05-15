<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Love Meet</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/header.css">
    <link rel="stylesheet" href="../public/css/tchat.css">
    <link rel="stylesheet" href="../public/css/profil.css">
    <link rel="stylesheet" href="../public/css/monProfil.css">
</head>

<body>
<div id="page_main">
    <div id="monProfile">
        <div id="photoDeProfile" class="container">
            <img src="<?= $_SESSION['photo'] ?>" alt="Photo de profil">
        </div>
        <div id="monProfile2" class="container">
            <a href="index.php?page=profil">Mon profil</a>
        </div>
    </div>

    <div id="boutons">
        <a href="index.php?page=accueil" class="bouton">Accueil</a>
        <a href="index.php?page=disconnected" class="bouton"><i class="fas fa-power-off"></i></a>
    </div>

    <div id="matchsBtn">
        <button >Voir Matchs</button>
    </div>
    <div id="listeNone">
        <div id="listeMatch">
            <h3>Liste des Matchs</h3>
            <ul>
                <?= $liste ?>
            </ul>
        </div>
    </div>
</div>

<?=$_SESSION['content']?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://kit.fontawesome.com/63da07ea19.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="../public/script/header.js"></script>
<script type="text/javascript" src="../public/script/tchat.js"></script>
<script type="text/javascript" src="../public/script/param.js"></script>
<script type="text/javascript" src="../public/script/accueil.js"></script>
</body>
</html>
