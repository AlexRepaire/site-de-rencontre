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
        $this->setIdConversation($_GET['id']);
        return $this->User->showMatchProfil($this->getIdMatch())->fetch_assoc();
    }

    public function deleteMatch()
    {
        $this->User->blockMatch($_POST['id']);
        if ($this->Auth->logged() == 1){
            header('location:index.php?page=accueil');
        }elseif ($this->Auth->logged() == 2){
            header('location:index.php?page=admin');
        }
    }

    public function showAllMessage()
    {
        $result = $this->showMatchProfil();
        $this->setIdConversation($_GET['id']);
        $res = $this->User->showAllMessage($this->getIdConversation());
        require "app/views/tchat.php";
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