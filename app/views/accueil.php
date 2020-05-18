<div id="page_accueil">
    <?php
    while ($row = $res->fetch_assoc()){
        ?>
        <div id="matchProfile">
            <div id="profil" style="background-image: url('<?= $row['photo'] ?>')">
                <div id="description">
                    <h2><?=$row['pseudo']?> / <?= $row['ville'] ?></h2>
                    <p><?= $row['description'] ?></p>
                </div>
            </div>
            <div id="actions">
                <form action="index.php?page=disLike" method="post">
                    <input type="hidden" name="delete" value="<?= $row['idUser'] ?>">
                    <button type="submit"><i class="fas fa-times"></i></button>
                </form>
                <form action="index.php?page=like" method="post">
                    <input type="hidden" name="insert" value="<?= $row['idUser'] ?>">
                    <button type="submit"><i class="fas fa-heart"></i></button>
                </form>
            </div>
        </div>
        <?php
    }
    ?>
</div>