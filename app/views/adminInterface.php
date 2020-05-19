<div id="page_admin">
    <h1>Espace administrateur</h1>

    <div id="listeUsers" class="scroll_bar">
        <table>
            <thead>
                <tr>
                    <th>Pseudo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Mail</th>
                    <th>Supprimer utilisateur</th>
                    <th>Voir profil</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc())
                {
                    ?>
                    <tr>
                        <td><?= $row['pseudo'] ?></td>
                        <td><?= $row['nom'] ?></td>
                        <td><?= $row['prenom'] ?></td>
                        <td><?= $row['mail'] ?></td>
                        <td>
                            <form action="index.php?page=deleteUser" method="post">
                                <input type="hidden" name="deleteUser" value="<?= $row['idUser'] ?>">
                                <input type="submit" value="Supprimer l'utilisateur">
                            </form>
                        </td>
                        <td><a href="index.php?page=viewProfil&idUser=<?= $row['idUser'] ?>">Voir profil</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>

    </div>
</div>