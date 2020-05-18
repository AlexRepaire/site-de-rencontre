<?php


namespace app;

class ControllerAccueil
{
    private $User;
    private $Auth;
    private $ageMin;
    private $ageMax;
    private $genre;
    private $limit = 1;
    private $idMatch;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }
    private function calculIntervalAge($ageMin,$ageMax)
    {
        $this->setAgeMin(date("Y-m-d", mktime(0,0,0, date("m"), date("d"),date("Y")-$ageMin)));
        $this->setAgeMax(date("Y-m-d", mktime(0,0,0, date("m"), date("d"), date("Y")-$ageMax)));
    }

    private function searchCondition()
    {
        $res = $this->User->searchCondition($this->Auth->getUserId());
        $row = $res->fetch_assoc();
            $this->setAgeMin($row['ageMin']);
            $this->setAgeMax($row['ageMax']);
            $this->setGenre($row['genre']);
            $this->calculIntervalAge($this->getAgeMin(),$this->getAgeMax());
    }

    public function searchProfil()
    {
        $this->searchCondition();
        $res = $this->User->searchProfil($this->getGenre(),$this->getAgeMin(),$this->getAgeMax(),$this->getLimit(),$this->getOffset() ,$this->Auth->getUserId());
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
        header("location:index.php?page=accueil");
    }

    public function disLike()
    {
        if (!empty($_POST['delete'])){
            $this->setOffset(1);
            $this->setIdMatch($_POST['delete']);
            $result = $this->User->checkDislike($this->Auth->getUserId(),$this->getIdMatch())->fetch_assoc();
            if ($result == NULL)
            {
                $this->User->disLikeProfil($this->Auth->getUserId(),$this->getIdMatch());
            }
        }
        header("location:index.php?page=accueil");
    }

    public function setAgeMin($ageMin)
    {
        $this->ageMin = $ageMin;
    }

    public function getAgeMin()
    {
        return $this->ageMin;
    }

    public function setAgeMax($ageMax)
    {
        $this->ageMax = $ageMax;
    }

    public function getAgeMax()
    {
        return $this->ageMax;
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