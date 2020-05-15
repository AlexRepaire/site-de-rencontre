<div id="page_profil" class="scroll_bar">
    <div id="navigation">
        <ul>
            <li class="line-right"><button id="comptebtn">Paramètre du compte</button></li>
            <li class="line-right"><button id="recherchebtn">Paramètre de recherche</button></li>
            <li><button id="contactbtn">Contact Administrateur</button></li>
        </ul>
    </div>
    <div id="gestionProfil" class="margin">
        <h2>Paramètres du compte</h2>
        <div>
            <form action="index?page=upload" method="post">
                <label for="file" class="label-file">Choisir une photo</label>
                <input id="file" name="file" class="input-file" type="file" onchange="previewFile()">
                <img src="" height="200" id="img" alt="Aperçu de l’image">

                <input type="submit" value="Valider la photo de profil">
            </form>

            <form action="index.php?page=updateParam" method="post">
                <label for="email">Mail</label>
                <input type="text" name="mail" id="mail" value="<?= $mail ?>">

                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password" value="<?= $password ?>">

                <input type="submit" value="Modifier infos">
            </form>

            <form action="index.php?page=deleteProfil" method="post" id="deleteProfil">
                <label for="deleteCompte">Pour supprimer votre compte entrer votre mot de passe :</label>
                <input type="password" name="delete" id="deleteCompte">
                <input type="submit" value="Supprimer mon compte">
            </form>
        </div>
    </div>
    <div id="parametreDeRecherche" class="margin">
        <h2>Paramètres de recherche</h2>
        <form action="index.php?page=updateSearch" method="post">
            <label for="genre">Recherche :</label>
            <select id="genre" name="genre">
                <option value="homme" <?php if ($genre == "homme"){?> selected='selected' <?php } ?> >Homme</option>
                <option value="femme" <?php if ($genre == "femme"){?> selected='selected' <?php } ?> >Femme</option>
            </select>

            <label for="ageMin">Age min: </label>
            <input type="min" name="ageMin" id="ageMin" value="<?= $ageMin ?>">

            <label for="ageMax">Age max: </label>
            <input type="max" name="ageMax" id="ageMax" value="<?= $ageMax ?>">

            <input type="submit" value="Valider">
        </form>
    </div>
    <div id="contact" class="margin">
        <h2>Contact</h2>
        <p>Veuillez écrire votre probleme, l'administrateur répondras des que possible!</p>
        <form action="../public/index.php?page=contactAdmin" method="post">
            <input type="text" name="textMessage" size="69" height="600px">
            <input type="submit" value="Valider">
        </form>
    </div>
</div>