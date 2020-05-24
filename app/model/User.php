<?php


namespace app;

class User
{
    private $Db;

    public function __construct(Db $db)
    {
        $this->Db = $db->mySQLI;
    }

    /*******Espace accueil*******/

    public function searchCondition($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM criterederecherche WHERE user_id = ?");
        $result->bind_param('i',$idUser);
        $result->execute();
        return $result->get_result();
    }

    public function searchLike($idUser)
    {
        $result = $this->Db->prepare("SELECT user_id_like_2 FROM aime WHERE user_id_Like = ?");
        $result->bind_param("i", $idUser);
        $result->execute();
        return $result->get_result();
    }

    public function searchProfil($genre,$ageMin,$ageMax,$limit,$offset, $idUser)
    {
        $likes = $this->searchLike($idUser)->fetch_all(MYSQLI_ASSOC);
        $array = array_column($likes, "user_id_like_2");
        $likesString = "";
        if (!empty($likes))
        {
            $likesString = join("','",$array);
        }
        $sql = "SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id LEFT JOIN photos ON users.idUser = photos.user_id WHERE genre = ? AND (dateDeNaissance <= ?) AND (dateDeNaissance >= ?)  AND idUser NOT IN ('$likesString') LIMIT ? OFFSET ?";
        $result = $this->Db->prepare($sql);
        $result->bind_param("sssii",$genre,$ageMin,$ageMax,$limit, $offset);
        $result->execute();
        return $result->get_result();
    }

    public function verifyMatch($idUser, $idMatch)
    {
        $res = $this->Db->prepare("SELECT * FROM aime WHERE user_id_Like = ? AND user_id_Like_2 = ?");
        $res->bind_param('ii',$idMatch,$idUser);
        $res->execute();
        return $res->get_result();
    }

    public function insertMatch($idUser, $idMatch)
    {
        $insert = $this->Db->prepare("INSERT INTO conversations (user_id_conv, user_id_conv_2) VALUES (?,?)");
        $insert->bind_param("ii", $idUser, $idMatch);
        $insert->execute();
    }

    public function checkDislike($idUser,$idMatch)
    {
        $res =$this->Db->prepare("SELECT * FROM dislike WHERE user_id_disLike = ? AND user_id_disLike_2 = ?");
        $res->bind_param("ii", $idUser, $idMatch);
        $res->execute();
        return $res->get_result();
    }

    public function disLikeProfil($idUser,$idMatch)
    {
        $insert = $this->Db->prepare("INSERT INTO dislike (user_id_disLike,user_id_disLike_2) VALUES (?,?)");
        $insert->bind_param("ii", $idUser,$idMatch);
        $insert->execute();
    }

    public function likeProfil($idUser,$idMatch)
    {
        $insert = $this->Db->prepare("INSERT INTO aime (user_id_Like,user_id_Like_2) VALUES (?,?)");
        $insert->bind_param("ii", $idUser,$idMatch);
        $insert->execute();
    }


    /************Espace header************/

    public function allMatch($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM conversations WHERE user_id_conv_2 = ? UNION SELECT * FROM conversations WHERE user_id_conv = ?");
        $result->bind_param("ii", $idUser,$idUser);
        $result->execute();
        return $result->get_result();
    }

    private function resList($match)
    {
        /*******CREATE 2 ARRAY -> FUSION ARRAY  ->  DELETE DOUBLONS*********/
        $array1 = array_column($match, 'user_id_conv');
        $array2 = array_column($match, 'user_id_conv_2');
        $idArray = array_unique(array_merge($array1,$array2));

        /******JOIN ELEMENTS ARRAY IN CHAIN******/
       return join("','", $idArray);
    }

    public function getUsersById($match)
    {
        $resList = $this->resList($match);
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN photos ON users.idUser = photos.user_id WHERE idUser IN ('$resList')");
        $result->execute();
        return $result->get_result();
    }


    /*********Espace tchat*********/

    public function showMatchProfil($idMatch)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id LEFT JOIN photos ON users.idUser = photos.user_id WHERE idUser = ?");
        $result->bind_param("i", $idMatch);
        $result->execute();
        return $result->get_result();
    }

    public function showAllMessage($idConv)
    {
        $result = $this->Db->prepare("SELECT * FROM messages LEFT JOIN conversations ON messages.conversations_id = conversations.idConversations LEFT JOIN users ON messages.user_id = users.idUser  WHERE conversations_id = ?");
        $result->bind_param("i", $idConv);
        $result->execute();
        return $result->get_result();
    }
/*
    public function sendMessage($message,$idUser,$idConv)
    {
        $insert = $this->Db->prepare("INSERT INTO messages (message,user_id,conversations_id) VALUES (?,?,?)");
        $insert->bind_param("sii",$message,$idUser,$idConv);
        $insert->execute();
    }
*/
    public function blockMatch($idConv){
        $delete = $this->Db->prepare("DELETE FROM conversations WHERE idConversations = ?");
        $delete->bind_param("i",$idConv);
        $delete->execute();
    }

    /*****espace param******/

    public function showParamProfil($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN criterederecherche ON users.idUser = criterederecherche.user_id LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id WHERE idUser = ?");
        $result->bind_param('i',$idUser);
        $result->execute();
        return $result->get_result();
    }

    public function showParamProfilAdmin($idAdmin)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN photos ON users.idUser = photos.user_id WHERE idUser = ?");
        $result->bind_param("i", $idAdmin);
        $result->execute();
        return $result->get_result();
    }

    public function updateParam($mail, $idUser)
    {
        $update = $this->Db->prepare("UPDATE users SET mail=? WHERE idUser = ?");
        $update->bind_param('si',$mail, $idUser);
        $update->execute();
    }

    public function updateUsersInfos($adresse,$pays,$ville,$bio,$idUser)
    {
        $update = $this->Db->prepare("UPDATE usersinfos SET adresse=? , ville=? , pays=? , description=? WHERE user_id=?");
        $update->bind_param("ssssi",$adresse,$ville,$pays,$bio,$idUser);
        $update->execute();
    }

    public function updatePassword($password, $idUser)
    {
        $update = $this->Db->prepare("UPDATE users SET password=? WHERE idUser=?");
        $update->bind_param("si",$password,$idUser);
        $update->execute();
    }

    public function verificationDelete($idUser,$password)
    {
        $result = $this->Db->prepare("SELECT * FROM users WHERE idUser = ? AND password = ?");
        $result->bind_param('is', $idUser,$password);
        $result->execute();
        return $result->get_result();
    }

    public function deleteUserProfil($idUser,$password)
    {
        $delete = $this->Db->prepare("DELETE FROM users WHERE idUser=? AND password=?");
        $delete->bind_param("is", $idUser,$password);
        $delete->execute();
        session_destroy();
        header('location:index.php?page=login');
    }

    public function updateSearch($ageMin,$ageMax,$genre,$idUser)
    {
        $update = $this->Db->prepare("UPDATE criterederecherche SET ageMin=?,ageMax=?,genreRecherche=? WHERE user_id=?");
        $update->bind_param('iisi',$ageMin,$ageMax,$genre,$idUser);
        $update->execute();
    }

    public function selectAdminId($idRole)
    {
        $contactAdmin = $this->Db->prepare("SELECT idUser FROM users WHERE role_id = ?");
        $contactAdmin->bind_param("i", $idRole);
        $contactAdmin->execute();
        return $contactAdmin->get_result();
    }

    private function contactAdmin($id,$id2)
    {
        $contact = $this->Db->prepare("INSERT INTO conversations (user_id_conv,user_id_conv_2) VALUES (?,?)");
        $contact->bind_param("ii",$id,$id2);
        $contact->execute();
        return $this->Db->insert_id;
    }

    public function insertMessageAdmin($message,$userId,$userId2)
    {
        $idConv = $this->contactAdmin($userId,$userId2);
        $insert = $this->Db->prepare("INSERT INTO messages (message,user_id,conversations_id) VALUES (?,?,?)");
        $insert->bind_param("sii",$message,$userId,$idConv);
        $insert->execute();
    }

    /*********ESPACE ADMIN***********/

    public function AllUser()
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id WHERE role_id = 1");
        $result->execute();
        return $result->get_result();
    }

    public function User($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id WHERE idUser = ?");
        $result->bind_param("i",$idUser);
        $result->execute();
        return $result->get_result();
    }

    public function deleteUser($idUser)
    {
        $delete = $this->Db->prepare("DELETE FROM users WHERE idUser = ?");
        $delete->bind_param("i", $idUser);
        $delete->execute();
    }

    /******************UPLOAD IMAGE******************/

    public function checkPhoto($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM photos WHERE user_id = ?");
        $result->bind_param("i", $idUser);
        $result->execute();
        return $result->get_result();
    }

    public function insertPhoto($photo,$idUser)
    {
        $insert = $this->Db->prepare("INSERT INTO photos (photo,user_id) VALUES (?,?)");
        $insert->bind_param("si",$photo,$idUser);
        $insert->execute();
    }

    public function updatePhoto($idPhoto,$photo)
    {
        $update = $this->Db->prepare("UPDATE photos SET photo=? WHERE idPhoto = ?");
        $update->bind_param("si",$photo,$idPhoto);
        $update->execute();
    }
}