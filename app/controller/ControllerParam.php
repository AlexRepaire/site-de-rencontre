<?php


namespace app;


class ControllerParam
{
    private $User;
    private $Auth;
    private $mail;
    private $password;
    private $ageMin;
    private $ageMax;
    private $genre;
    private $message;
    private $adresse;
    private $pays;
    private $ville;
    private $bio;

    private $suporttedFormats = ['image/png','image/jpeg','image/jpg','image/gif'];
    private $target_dir = "../public/images/";
    private $target_file;
    private $idPhoto;


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
            $adresse = $row['adresse'];
            $ville = $row['ville'];
            $pays = $row['pays'];
            $bio = $row['description'];
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
            require "../app/views/monProfilAdmin.php";
        }
    }

    private function uploadFile($file)
    {
        if (is_array($file))
        {
            if (in_array($file['type'],$this->suporttedFormats))
            {
                if ($file['size'] < 5000000)
                {
                    $res = $this->User->checkPhoto($this->Auth->getUserId())->fetch_assoc();
                    var_dump($res['idPhoto']);
                    $this->setTargetFile($file['name']);
                    if ($res != NULL)
                    {
                        /*********A REVOIR !!!!!!!!!**********/
                        $this->setIdPhoto($res['idPhoto']);
                        unlink($res['photo']);
                        $this->User->updatePhoto($this->getIdPhoto(),$this->getTargetFile());
                        move_uploaded_file($file['tmp_name'],$this->getTargetDir().$file['name']);
                        $_SESSION['photo'] = $this->getTargetDir().$file['name'];
                        if ($this->Auth->logged() === 1)
                        {
                            header('location:index.php?page=profil');
                        }
                        elseif ($this->Auth->logged() === 2)
                        {
                            header('location:index.php?page=profilAdmin');
                        }
                    }else{
                        $this->User->insertPhoto($this->getTargetFile(),$this->Auth->getUserId());
                        move_uploaded_file($file['tmp_name'],$this->getTargetDir().$file['name']);
                        if ($this->Auth->logged() === 1)
                        {
                            header('location:index.php?page=profil');
                        }
                        elseif ($this->Auth->logged() === 2)
                        {
                            header('location:index.php?page=profilAdmin');
                        }
                    }
                }else{
                    echo "le fichier dois faire moins de 5 MO";
                }
            }else{
                echo "format n'est pas supporté";
            }
        }else{
            echo "fichier non upload";
        }
    }
    public function upload()
    {
        if (isset($_FILES['file']))
        {
            $this->uploadFile($_FILES['file']);
        }else{
            echo "la fichier n'à pas été upload";
        }
    }


    public function updateParam()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['adresse']) AND !empty($_POST['pays']) AND !empty($_POST['ville']) AND !empty($_POST['bio'])){
            $this->setMail($_POST['mail']);
            $this->setAdresse($_POST['adresse']);
            $this->setPays($_POST['pays']);
            $this->setVille($_POST['ville']);
            $this->setBio($_POST['bio']);
            //$this->setPassword(sha1($_POST['password']));
            $this->User->updateParam($this->getMail(),$this->Auth->getUserId());
            $this->User->updateUsersInfos($this->getAdresse(),$this->getPays(),$this->getVille(),$this->getBio(),$this->Auth->getUserId());
        }
        header("location:index.php?page=profil");
    }

    public function updatePassword()
    {
        if (!empty($_POST['password']) AND !empty($_POST['password2']))
        {
            if ($_POST['password'] === $_POST['password2'])
            {
                $this->setPassword(sha1($_POST['password']));
                $this->User->updatePassword($this->getPassword(),$this->Auth->getUserId());
            }else{
                echo "les mots de passe sont différents";
            }
        }else{
            echo "Au moins un des champs est vide";
        }
        if ($this->Auth->logged() === 1)
        {
            header('location:index.php?page=profil');
        }
        elseif ($this->Auth->logged() === 2)
        {
            header('location:index.php?page=profilAdmin');
        }    }

    public function updateParamAdmin()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['password'])){
            $this->setMail($_POST['mail']);
            $this->User->updateParam($this->getMail(),$this->Auth->getUserId());
        }
        header('location:index.php?page=profilAdmin');
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
        header("location:index.php?page=profil");
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
        header("location:index.php?page=profil");
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

    public function setAdresse($adresse){
        $this->adresse = $adresse;
    }

    public function getAdresse(){
        return $this->adresse;
    }

    public function setPays($pays){
        $this->pays = $pays;
    }

    public function getPays(){
        return $this->pays;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }

    public function getVille(){
        return $this->ville;
    }

    public function setBio($bio){
        $this->bio = $bio;
    }

    public function getBio(){
        return $this->bio;
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

    public function getTargetDir()
    {
        return $this->target_dir;
    }

    public function setTargetFile($file)
    {
        $this->target_file = $this->getTargetDir().$file;
    }

    public function getTargetFile()
    {
        return $this->target_file;
    }

    public function setIdPhoto($id)
    {
        $this->idPhoto = $id;
    }

    public function getIdPhoto()
    {
        return $this->idPhoto;
    }
}