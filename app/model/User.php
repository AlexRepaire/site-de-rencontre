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

    public function searchProfil($genre,$limit,$offset, $idUser)
    {
        $likes = $this->searchLike($idUser)->fetch_all(MYSQLI_ASSOC);
        $array = array_column($likes, "user_id_like_2");
        $likesString = "";
        if (!empty($likes))
        {
            $likesString = join("','",$array);
        }
        $sql = "SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id WHERE genre = ? AND idUser NOT IN ('$likesString') LIMIT ? OFFSET ?";
        $result = $this->Db->prepare($sql);
        $result->bind_param("sii",$genre,$limit, $offset);
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
        $result = $this->Db->prepare(
        <<<'SQL'
            SELECT
                *
            FROM
                conversations
            RIGHT JOIN users ON users.idUser = conversations.user_id_conv_2
            WHERE
                idUser = ? AND idConversations IS NOT NULL
            UNION
            SELECT
                *
            FROM
                conversations
            RIGHT JOIN users ON users.idUser = conversations.user_id_conv
            WHERE
                idUser = ? AND idConversations IS NOT NULL
SQL
        );
        $result->bind_param("ii", $idUser,$idUser);
        $result->execute();
        return $result->get_result();
    }

    public function getUsersById($match)
    {
         /*******CREATE 2 ARRAY -> FUSION ARRAY  ->  DELETE DOUBLONS*********/
        $array1 = array_column($match, 'user_id_conv');
        $array2 = array_column($match, 'user_id_conv_2');
        $idArray = array_unique(array_merge($array1,$array2));

            /******JOIN ELEMENTS ARRAY IN CHAIN******/
        $resList = join("','", $idArray);
        $result = $this->Db->prepare("SELECT * FROM users WHERE idUser IN ('$resList')");
        $result->execute();
        return $result->get_result();
    }


    /*********Espace tchat*********/

    public function showMatchProfil($idMatch)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN usersinfos ON users.idUser = usersinfos.user_id WHERE idUser = ?");
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
    public function blockMatch(){

    }

    /*****espace param******/

    public function showParamProfil($idUser)
    {
        $result = $this->Db->prepare("SELECT * FROM users LEFT JOIN criterederecherche ON users.idUser = criterederecherche.user_id WHERE idUser = ?");
        $result->bind_param('i',$idUser);
        $result->execute();
        return $result->get_result();
    }

    public function showParamProfilAdmin($idAdmin)
    {
        $result = $this->Db->prepare("SELECT * FROM users WHERE idUser = ?");
        $result->bind_param("i", $idAdmin);
        $result->execute();
        return $result->get_result();
    }

    public function updateParam($mail, $password, $idUser)
    {
        $update = $this->Db->prepare("UPDATE users SET mail=?, password=? WHERE idUser = ?");
        $update->bind_param('ssi',$mail, $password, $idUser);
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
        header('location:../public/index.php?page=login');
    }

    public function updateSearch($ageMin,$ageMax,$genre,$idUser)
    {
        $update = $this->Db->prepare("UPDATE criterederecherche SET ageMin=?,ageMax=?,genre=?,user_id=? WHERE idRecherche=?");
        $update->bind_param('iisi',$ageMin,$ageMax,$genre,$idUser);
        $update->execute();
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
}