<?php


namespace app;


class controllerParam
{
    private $User;
    private $Auth;
    private $mail;
    private $password;
    private $ageMin;
    private $ageMax;
    private $genre;
    private $message;

    private $target_dir = "public/images/";
    private $suporttedFormats = ['image/png','image/jpeg','image/jpg','image/gif'];


    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    public function showParamProfil()
    {
        $result = $this->User->showParamProfil($this->Auth->getUserId());
        $row = $result->fetch_assoc();
        if ($row != NULL){
            $mail = $row['mail'];
            $ageMin = $row['ageMin'];
            $ageMax = $row['ageMax'];
            $genre = $row['genre'];
            require "../app/views/monProfil.php";
        }
    }

    public function showParamProfilAdmin()
    {
        $result = $this->User->showParamProfilAdmin($this->Auth->getUserId());
        $row = $result->fetch_assoc();
        if ($row != NULL){
            $mail = $row['mail'];
            $password = sha1($row['password']);
            require "../app/views/monProfilAdmin.php";
        }
    }

    public function uploadFile()
    {
        if (!empty($_POST['submit'])) {

            $file = $_FILES['file'];/*
            if ($file['error'] == 0)
            {
                if ($file['size'] > 1500000){
                    echo "Votre fichier est trop lourd";
                }
                if (in_array($file['type'],$this->suporttedFormats)){
                    echo "Votre fichier n'est pas conforme";
                }
            }else{
                move_uploaded_file($file['tmp_name'],'../public/images/'.$file['name']); //Deplace un fichier télécharger
                echo 'Le fichier est bien upload';
            }
        } */

            if (is_array($file)) //Détermine si la variable est un tableau
            {
                if (in_array($file['type'], $this->$this->suporttedFormats)) //si le type de fichier est dans le tableau des formats supportés
                {
                    move_uploaded_file($file['tmp_name'], '../public/images/' . $file['name']); //Deplace un fichier télécharger
                    echo 'Le fichier est bien upload';
                }
                echo "Le format du fichier n'est pas supporté";
            } else {
                echo "Le fichier n'est pas upload";
            }
        }
    }

    public function updateParam()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['password'])){
            $this->setMail($_POST['mail']);
            $this->setPassword(sha1($_POST['password']));
            $this->User->updateParam($this->getMail(),$this->getPassword(),$this->Auth->getUserId());
        }
        header("location:../public/index.php?page=profil");
    }

    public function updateParamAdmin()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['password'])){
            $this->setMail($_POST['mail']);
            $this->setPassword(sha1($_POST['password']));
            $this->User->updateParam($this->getMail(),$this->getPassword(),$this->Auth->getUserId());
        }
        header('location:../public/index.php?page=profilAdmin');
    }

    public function deleteProfil()
    {
        if (!empty($_POST['delete'])){
            $this->setPassword(sha1($_POST['delete']));
            $res = $this->User->verificationDelete($this->Auth->getUserId(),$this->getPassword())->fetch_assoc();
            if ($res == NULL)
            {
                echo "<script>alert('mot de passe incorrect')</script>";
            }else{
                $this->User->deleteUserProfil($this->Auth->getUserId(),$this->getPassword());
            }
        }
    }

    public function updateSearch()
    {
        if (!empty($_POST['genre']) AND !empty($_POST['ageMin']) AND !empty($_POST['ageMax'])){
            $this->setGenre($_POST['genre']);
            $this->setAgeMin($_POST['ageMin']);
            $this->setAgeMax($_POST['ageMax']);
            $this->User->updateSearch($this->getAgeMin(),$this->getAgeMax(),$this->getGenre(),$this->Auth->getUserId());
        }
        header("location:../public/index.php?page=profil");
    }

    public function contactAdmin()
    {
        if (!empty($_POST['textMessage']))
        {
            $this->setMessage($_POST['textMessage']);
            $res = $this->User->selectAdminId(2)->fetch_assoc();
            if ($res != NULL)
            {
                $this->User->insertMessageAdmin($this->getMessage(),$this->Auth->getUserId(),$res['idUser']);
            }
        }
        header("location:../public/index.php?page=profil");
    }

    public function setMail($mail){
        $this->mail = $mail;
    }

    public function getMail(){
        return $this->mail;
    }

    public function setPassword($password){
        $this->password = $password;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setAgeMin($ageMin){
        $this->ageMin = $ageMin;
    }

    public function getAgeMin(){
        return $this->ageMin;
    }

    public function setAgeMax($ageMax){
        $this->ageMax = $ageMax;
    }

    public function getAgeMax(){
        return $this->ageMax;
    }

    public function setGenre($genre){
        $this->genre = $genre;
    }

    public function getGenre(){
        return $this->genre;
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function getMessage(){
        return $this->message;
    }

}