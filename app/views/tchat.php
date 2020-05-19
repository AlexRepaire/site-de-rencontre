<div id="page_tchat">
    <div id="tchat">
        <div id="tchat_container">
            <div id="all_messages" class="scroll_bar">
                <?php while ($row = $res->fetch_assoc())
                {
                    ?>
                    <div class="message_sent <?php if ($this->Auth->getUserId() === $row['user_id']){echo 'me';} ?>">
                        <?php if ($this->Auth->getUserId() != $row['user_id']){
                            ?>
                            <p class="pseudo_sent"><?= $row['pseudo'] ?></p>
                            <?php
                        } ?>
                        <p class="message_corpus"><?= $row['message'] ?></p>
                    </div>
                    <?php
                }
                ?>
            </div>

            <div id="send_bar">
                <script>let convId = <?= $this->getIdConversation() ?>;
                    let idUser = <?= $this->Auth->getUserId() ?>;</script>
                <form action="#" onsubmit="return postMessage();">
                    <input id="input_txt" type="text" name="message">
                    <input id="input_sbmt" type="submit" value="Envoyer">
                </form>
                <button id="showProfil">Voir Profil</button>
            </div>
        </div>
    </div>

    <div id="matchProfileTchat">
        <img src="<?=$result['photo'] ?>" style="width: 100%">
        <div id="descriptionProfil" class="scroll_bar">
            <h2><?= $result['pseudo'] ?></h2>
            <h3>Ville: <?= $result['ville'] ?></h3>
            <h4>Description:</h4>
            <p><?= $result['description'] ?></p>
        </div>
        <button id="retour">Retour à la discussion</button>
        <div id="bloquer">
            <?php if ($this->Auth->logged() == 1): ?>
                <form action="index.php?page=deleteMatch" method="post">
                    <input type="hidden" name="id" value="<?= $this->getIdConversation() ?>">
                    <input type="submit" value="Supprimer des matchs">
                </form>
            <?php elseif ($this->Auth->logged() == 2): ?>
                <form action="index.php?page=deleteMatch" method="post">
                    <input type="hidden" name="id" value="<?= $this->getIdConversation() ?>">
                    <input type="submit" value="Supprimer L'utilisateur de la liste">
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>