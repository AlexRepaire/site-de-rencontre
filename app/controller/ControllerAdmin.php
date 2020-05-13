<?php


namespace app;


class ControllerAdmin
{
    private $User;
    private $Auth;
    private $idUser;
    private $pseudo;

    public function __construct()
    {
        $this->User = new User(new Db());
        $this->Auth = new Auth(new Db());
    }

    public function AllUsers()
    {
        $result = $this->User->AllUser();
        ob_start();
        while ($row = $result->fetch_assoc())
        {
            ?>
            <tr>
                <td><?= $row['pseudo'] ?></td>
                <td><?= $row['nom'] ?></td>
                <td><?= $row['prenom'] ?></td>
                <td><?= $row['mail'] ?></td>
                <td><form action="" method="post">
                    <input type="submit" value="Envoyer un message">
                    </form></td>
                <td><form action="../public/index.php?page=deleteUser" method="post">
                    <input type="hidden" name="deleteUser" value="<?= $row['idUser'] ?>">
                    <input type="submit" value="Supprimer l'utilisateur">
                    </form></td>
                <td><a href="../public/index.php?page=viewProfil&idUser=<?= $row['idUser'] ?>">Voir profil</a></td>
            </tr>
            <?php
        }
        $allUsers = ob_get_clean();
        require "../app/views/adminInterface.php";
    }

    public function viewProfil()
    {
        $this->setIdUser($_GET['idUser']);
        $res = $this->User->User($this->getIdUser())->fetch_assoc();
        ob_start();
        ?>
            <h1>Utilisateur : <?= $res['nom'] ?> <?= $res['prenom']  ?></h1>
            <img src="" alt="">
            <p>Pseudo: <?= $res['pseudo'] ?></p>
            <p>Genre: <?= $res['genre'] ?></p>
            <p>Mail: <?= $res['mail'] ?></p>
            <p>Adresse: <?= $res['adresse'] ?></p>
            <p>Ville: <?= $res['ville'] ?></p>
            <p>Pays: <?= $res['pays'] ?></p>
            <p>Description: <?= $res['description'] ?></p>
            <p>Date de naissance: <?= $res['dateDeNaissance'] ?></p>
            <form action="" method="post">
                <input type="submit" value="Envoyer un message">
            </form>
            <form action="../public/index.php?page=deleteUser" method="post">
                <input type="hidden" name="deleteUser" value="<?= $res['idUser'] ?>">
                <input type="submit" value="Supprimer l'utilisateur">
            </form>
        <?php
        $contentUser = ob_get_clean();
        require "../app/views/profilUser.php";
    }

    public function deleteUser()
    {
        $this->setIdUser($_POST['deleteUser']);
        $this->User->deleteUser($this->getIdUser());
        header('location:../public/index.php?page=admin');
    }

    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

}