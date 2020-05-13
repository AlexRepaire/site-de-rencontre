<?php

$db = new mysqli('localhost', 'root', '', 'site_de_rencontre');

$result = $db->prepare("SELECT * FROM messages LEFT JOIN conversations ON messages.conversations_id = conversations.idConversations LEFT JOIN users ON messages.user_id = users.idUser  WHERE conversations_id = ?");
$result->bind_param("i", $_GET['id']);
$result->execute();
$res = $result->get_result();

$html = "";

while ($row = $res->fetch_assoc())
{
$me = $_GET['idUser'] == $row['user_id'];
     $html .='<div class="message_sent '. ($me ? 'me' : '').'">
        <p class="message_corpus">'.$row['message'].'</p>
    </div>';
}

echo $html;
