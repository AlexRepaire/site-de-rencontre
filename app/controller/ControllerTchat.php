<?php


namespace app;


class ControllerTchat
{
    private $User;
    private $Auth;

    private $idMatch;
    private $idConv;
    private $message;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    public function showMatchProfil()
    {
        $this->setIdMatch($_GET['idUser']);
        $res = $this->User->showMatchProfil($this->getIdMatch());
        $row = $res->fetch_assoc();
        ob_start();
        ?>
                <img src="../images/Armand-Taille-en1999.jpg" style="width: 100%">
                <div id="description" class="scroll_bar">
                    <h2><?= $row['pseudo'] ?></h2>
                    <h3>Ville: <?= $row['ville'] ?></h3>
                    <h4>Description:</h4>
                    <p><?= $row['description'] ?></p>
                </div>
                <button id="retour">Retour à la discussion</button>
                <div id="bloquer">
                    <form action="" method="post">
                        <input type="submit" value="Supprimer des matchs">
                    </form>
                </div>
        <?php
        $_SESSION['matchProfil'] = ob_get_clean();
    }

    public function showAllMessage()
    {
        $this->setIdConversation($_GET['id']);
        $_SESSION['idConv'] = $this->getIdConversation();
        $res = $this->User->showAllMessage($this->getIdConversation());

        ob_start();
        while ($row = $res->fetch_assoc())
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
        $allMessages = ob_get_clean();
        ob_start();
        ?>
            <script>window.convId = <?= $this->getIdConversation() ?>;
            window.idUser = <?= $this->Auth->getUserId() ?>;</script>
            <form action="#" onsubmit="return postMessage();">
                <input id="input_txt" type="text" name="message">
                <input id="input_sbmt" type="submit" value="Envoyer">
            </form>
        <button id="showProfil">Voir Profil</button>
        <?php
        $formSend = ob_get_clean();
        require "../app/views/tchat.php";
    }

    public function setIdMatch($idMatch)
    {
        $this->idMatch = $idMatch;
    }

    public function getIdMatch()
    {
        return $this->idMatch;
    }

    public function setIdConversation($idConv)
    {
        $this->idConv = $idConv;
    }

    public function getIdConversation()
    {
        return $this->idConv;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    public function getMessage()
    {
        return $this->message;
    }
}