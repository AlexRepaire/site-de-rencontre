<?php


namespace app;


class ControllerAdmin
{
    private $User;
    private $Auth;
    private $idUser;
    private $pseudo;
    private $message;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    public function AllUsers()
    {
        $result = $this->User->AllUser();
        require "app/views/adminInterface.php";
    }

    public function viewProfil()
    {
        $this->setIdUser($_GET['idUser']);
        $res = $this->User->User($this->getIdUser())->fetch_assoc();
        require "app/views/profilUser.php";
    }

    public function contactUser()
    {
        if (!empty($_POST['textMessage']))
        {
            $this->setMessage($_POST['textMessage']);
            $this->setIdUser($_POST['idUser']);
            $this->User->insertMessageAdmin($this->getMessage(),$this->Auth->getUserId(),$this->getIdUser());
        }
    }

    public function deleteUser()
    {
        $this->setIdUser($_POST['deleteUser']);
        $this->User->deleteUser($this->getIdUser());
        header('location:index.php?page=admin');
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdUser()
    {
        return $this->idUser;
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