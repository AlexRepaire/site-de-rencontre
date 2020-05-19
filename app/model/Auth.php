<?php


namespace app;


class Auth
{
    private $Db;

    public function __construct(Db $db)
    {
        $this->Db = $db->mySQLI;
    }

    public function login($mail,$password)
    {
        $user = $this->Db->prepare("SELECT role_id,idUser,photo FROM users LEFT JOIN photos ON users.idUser = photos.user_id WHERE mail = ? AND password = ?");
        $user->bind_param('ss',$mail,$password);
        $user->execute();
        return $user->get_result();
    }

    public function checkPseudo($pseudo)
    {
        $res = $this->Db->prepare("SELECT pseudo FROM users WHERE pseudo = ? ");
        $res->bind_param("s", $pseudo);
        $res->execute();
        return $res->get_result();
    }
    public function checkMail($mail)
    {
        $res = $this->Db->prepare("SELECT mail FROM users WHERE mail = ? ");
        $res->bind_param("s", $mail);
        $res->execute();
        return $res->get_result();
    }

    public function register($pseudo,$mail,$password,$role)
    {
        $insert = $this->Db->prepare("INSERT INTO users (pseudo, mail, password,role_id) VALUES (?,?,?,?)");
        $insert->bind_param('sssi', $pseudo,$mail,$password,$role);
        $insert->execute();
        return $this->Db->insert_id;
    }

    public function postRegister($nom,$prenom,$adresse,$ville,$pays,$description,$dateDeNaissance,$genre,$idUser)
    {
        $insert = $this->Db->prepare("INSERT INTO usersinfos (nom, prenom, adresse, ville, pays, description, dateDeNaissance, genre, user_id) VALUES (?,?,?,?,?,?,?,?,?)");
        $insert->bind_param('ssssssssi',$nom,$prenom,$adresse,$ville,$pays,$description,$dateDeNaissance,$genre,$idUser);
        if ($insert->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function insertSearch($ageMin,$ageMax,$genre)
    {
        $insert = $this->Db->prepare("INSERT INTO criterederecherche (ageMin,ageMax,genre,user_id) VALUES (?,?,?,?)");
        $insert->bind_param('iisi',$ageMin,$ageMax,$genre,$_SESSION['id_user']);
        if ($insert->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function disConnected()
    {
        session_unset();
        session_destroy();
    }

    public function setLogged($roleId){
        $_SESSION['role_id'] = $roleId;
    }

    public function logged(){
        $role_id = NULL;
        if (isset($_SESSION['role_id']))
        {
            $role_id = $_SESSION['role_id'];
        }
        return $role_id;
    }

    public function setUserId($id_user){
        $_SESSION['id_user'] = $id_user;
    }

    public function getUserId(){
        return $_SESSION['id_user'];
    }

    public function setPhoto($photo)
    {
        $_SESSION['photo'] = $photo;
    }

    public function getPhoto()
    {
        return $_SESSION['photo'];
    }
}