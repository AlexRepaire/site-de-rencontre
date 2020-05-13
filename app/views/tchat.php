<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tchat</title>
    <meta name="viewport" content="width=device-width, user-scalable=no">
    <link rel="stylesheet" href="../public/css/tchat.css">
</head>

<body>
    <div id="page_tchat">
        <div id="container">
            <div id="tchat_container">
                <div id="all_messages" class="scroll_bar">
                    <?= $allMessages ?>
                </div>
                <div id="send_bar">
                    <?= $formSend ?>
                </div>
            </div>
        </div>

        <div id="matchProfile">
            <?= $_SESSION['matchProfil'] ?>
        </div>
        </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="../public/script/tchat.js"></script>
</body>
</html>