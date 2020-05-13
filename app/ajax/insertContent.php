<?php
$db = new mysqli('localhost', 'root', '', 'site_de_rencontre');

    $insert = $db->prepare("INSERT INTO messages (message,user_id,conversations_id) VALUES (?,?,?)");
    $insert->bind_param("sii",$_POST['message'],$_POST['idUser'],$_POST['id']);
    $insert->execute();