<?php
namespace app;


class controllerLogin{
    private $Auth;

    private $mail;
    private $password;
    private $password2;
    private $pseudo;
    private $role = 1;

    private $nom;
    private $prenom;
    private $adresse;
    private $ville;
    private $pays;
    private $description;
    private $dateDeNaissance;
    private $genre;
    private $ageMin;
    private $ageMax;
    private $genreSearch;

    public function __construct()
    {
        $this->Auth = new Auth(new Db());
    }

    public function checkLogin()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['password'])){
            $this->setMail($_POST['mail']);
            $this->setPassword(sha1($_POST['password']));
            $result = $this->Auth->login($this->getMail(),$this->getPassword())->fetch_assoc();
            if ($result != NULL)
            {
                $this->Auth->setLogged($result['role_id']);
                $this->Auth->setUserId($result['idUser']);
                $this->Auth->setPhoto($result['photo']);

                if ($this->Auth->logged() === 1)
                {
                    $_SESSION['offset'] = 0;
                    header('location:../public/index.php?page=accueil');
                }
                elseif($this->Auth->logged() === 2)
                {
                    header('location:../public/index.php?page=admin');
                }
            }
            echo 'identifiant incorrect';
        }
    }

    public function register()
    {
        if (!empty($_POST['mail']) AND !empty($_POST['password']) AND !empty($_POST['password2']) AND !empty($_POST['pseudo']))
        {
            $this->setMail($_POST['mail']);
            $this->setPassword(sha1($_POST['password']));
            $this->setPassword2(sha1($_POST['password2']));
            $this->setPseudo($_POST['pseudo']);
        }

        if ($this->getPassword() === $this->getPassword2())
        {
            $resPseudo = $this->Auth->checkPseudo($this->getPseudo())->fetch_assoc();
            if ($resPseudo == NULL)
            {
                $resMail = $this->Auth->checkMail($this->getMail())->fetch_assoc();
                if ($resMail == NULL)
                {
                    $res = $this->Auth->register(
                        $this->getPseudo(),
                        $this->getMail(),
                        $this->getPassword(),
                        $this->getRole());
                    $this->Auth->setUserId($res);
                    if (!empty($this->Auth->getUserId()))
                    {
                        header('location:../public/index.php?page=postRegister');
                    }
                }else{
                    echo "Mail est deja utilisé";
                }
            }else{
                echo "Pseudo est deja utilisé";
            }
        }
    }

    public function postRegister()
    {
        if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['adresse']) AND !empty($_POST['ville'])
            AND !empty('pays') AND !empty('description') AND !empty('birthday') AND !empty('genre') AND !empty('ageMin')
            AND !empty('ageMax' AND !empty('genre')))
        {
            $this->setNom($_POST['nom']);
            $this->setPrenom($_POST['prenom']);
            $this->setAdresse($_POST['adresse']);
            $this->setVille($_POST['ville']);
            $this->setPays($_POST['pays']);
            $this->setDescription($_POST['description']);
            $this->setDateDeNaissance($_POST['birthday']);
            $this->setGenre($_POST['genre']);
            $this->setAgeMin($_POST['ageMin']);
            $this->setAgeMax($_POST['ageMax']);
            $this->setGenreSearch($_POST['genreMatch']);
        }

        if (!empty($this->Auth->getUserId()))
        {
            $res = $this->Auth->postRegister(
                $this->getNom(),
                $this->getPrenom(),
                $this->getAdresse(),
                $this->getVille(),
                $this->getPays(),
                $this->getDescription(),
                $this->getDateDeNaissance(),
                $this->getGenre(),
                $this->Auth->getUserId()
            );
            $res2 = $this->Auth->insertSearch(
                $this->getAgeMin(),
                $this->getAgeMax(),
                $this->getGenreSearch()
            );
            if ($res === true AND $res2 === true)
            {
                $this->disconnected();
            }
        }
    }

    public function disconnected()
    {
        $this->Auth->disConnected();
        header('location: ../public');
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

    public function setPassword2($password2){
        $this->password2 = $password2;
    }

    public function getPassword2(){
        return $this->password2;
    }

    public function setPseudo($pseudo){
        $this->pseudo = $pseudo;
    }

    public function getPseudo(){
        return $this->pseudo;
    }

    public function getRole(){
        return $this->role;
    }

    public function setNom($nom){
        $this->nom = $nom;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setPrenom($prenom){
        $this->prenom = $prenom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function setAdresse($adresse){
        $this->adresse = $adresse;
    }

    public function getAdresse(){
        return $this->adresse;
    }

    public function setVille($ville){
        $this->ville = $ville;
    }

    public function getVille(){
        return $this->ville;
    }

    public function setPays($pays){
        $this->pays = $pays;
    }

    public function getPays(){
        return $this->pays;
    }

    public function setDescription($description){
        $this->description = $description;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDateDeNaissance($dateDeNaissance){
        $this->dateDeNaissance = $dateDeNaissance;
    }

    public function getDateDeNaissance(){
        return date("Y-m-d", strtotime($this->dateDeNaissance));
    }

    public function setGenre($genre){
        $this->genre = $genre;
    }

    public function getGenre(){
        return $this->genre;
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

    public function setGenreSearch($genre){
        $this->genreSearch = $genre;
    }

    public function getGenreSearch(){
        return $this->genreSearch;
    }}