<?php


namespace app;

class controllerAccueil
{
    private $User;
    private $Auth;
    private $genre;
    private $limit = 1;
    private $idMatch;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    public function searchCondition()
    {
        $res = $this->User->searchCondition($this->Auth->getUserId());
        $row = $res->fetch_assoc();
            $this->setGenre($row['genre']);
    }

    public function searchProfil()
    {
        $res = $this->User->searchProfil($this->getGenre(),$this->getLimit(),$this->getOffset() ,$this->Auth->getUserId());
        ob_start();
        while ($row = $res->fetch_assoc()){
            ?>
            <div id="matchProfile">
                <div id="container">
                    <div id="description">
                        <h2><?=$row['pseudo']?> / <?= $row['ville'] ?></h2>
                        <p><?= $row['description'] ?></p>
                    </div>
                </div>
                <div id="actions">
                    <form action="../public/index.php?page=accueil" method="post">
                        <input type="hidden" name="delete" value="<?= $row['idUser'] ?>">
                        <button type="submit"><i class="fas fa-times"></i></button>
                    </form>
                    <form action="../public/index.php?page=accueil" method="post">
                        <input type="hidden" name="insert" value="<?= $row['idUser'] ?>">
                        <button type="submit"><i class="fas fa-heart"></i></button>
                    </form>
                </div>
            </div>
            <?php
        }
        $contentProfil = ob_get_clean();
        require "../app/views/accueil.php";

    }

    public function like()
    {
        if (!empty($_POST['insert'])){
            $this->setIdMatch($_POST['insert']);
            $this->User->likeProfil($this->Auth->getUserId(),$this->getIdMatch());

            $result = $this->User->verifyMatch($this->Auth->getUserId(),$this->getIdMatch());
            $row = $result->fetch_assoc();
            if ($row != NULL)
            {
                $this->User->insertMatch($this->Auth->getUserId(),$this->getIdMatch());
            }
        }
    }

    public function disLike()
    {
        if (!empty($_POST['delete'])){
            $this->setOffset(1);
            $this->setIdMatch($_POST['delete']);
            $this->User->disLikeProfil($this->Auth->getUserId(),$this->getIdMatch());
        }
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function setIdMatch($idMatch)
    {
        $this->idMatch = $idMatch;
    }

    public function getIdMatch()
    {
        return $this->idMatch;
    }

    public function setOffset($offset)
    {
        $_SESSION['offset'] = $_SESSION['offset'] + $offset;
    }

    public function getOffset(){
        return $_SESSION['offset'];
    }

}