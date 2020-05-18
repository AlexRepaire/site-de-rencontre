<?php


namespace app;


class ControllerHeader
{
    private $User;
    private $Auth;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    private function arrayMatchs()
    {
        /*****tableau qui va stocker les matchs et idconv ********/
        return $this->User->allMatch($this->Auth->getUserId())->fetch_all(MYSQLI_ASSOC);
    }

    public function allMatch()
    {
        $match = $this->arrayMatchs();
            /*******GET USERS INFOS ARRAY **********/
        $res = $this->User->getUsersById($match)->fetch_all(MYSQLI_ASSOC);

        //Création tableau vide qui va stocker les infos de chaque user indexé avec leur id
        $matchUsers = [];
        foreach ($res as $user){
            $matchUsers[$user['idUser']] = $user;
        }

        if ($this->Auth->logged() === 1){
            require "../app/views/header.php";
        }elseif ($this->Auth->logged() === 2){
            require "../app/views/headerAdmin.php";
        }
    }
}