<?php


namespace app;


class ControllerHeader
{

    private $User;
    private $Auth;

    private $pseudo;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    private function arrayMatchs()
    {
        /*****GET MATCHS ARRAY ********/
        return $this->User->allMatch($this->Auth->getUserId())->fetch_all(MYSQLI_ASSOC);
    }

    public function allMatch()
    {
        $match = $this->arrayMatchs();
            /*******GET USERS ARRAY **********/
        $res = $this->User->getUsersById($match)->fetch_all(MYSQLI_ASSOC);

        $matchUsers = [];
        foreach ($res as $user){
            $matchUsers[$user['idUser']] = $user;
        }

        ob_start();
        foreach($match as $row)
        {
            $matchId = $row['user_id_conv'];
            if ($matchId === $this->Auth->getUserId()){
                $matchId = $row['user_id_conv_2'];
            }
            ?>
            <a href="../public/index.php?page=tchat&id=<?= $row['idConversations'] ?>&idUser=<?= $matchUsers[$matchId]['idUser'] ?>">
                <li>
                    <div>
                        <img src="<?= $matchUsers[$matchId]['photo'] ?>" alt="">
                    </div>
                    <div>
                        <p><?= $matchUsers[$matchId]['pseudo'] ?></p>
                    </div>
                </li>
            </a>
            <?php
        };
        $liste = ob_get_clean();
        if ($this->Auth->logged() === 1){
            require "../app/views/header.php";
        }elseif ($this->Auth->logged() === 2){
            require "../app/views/headerAdmin.php";
        }
    }
}