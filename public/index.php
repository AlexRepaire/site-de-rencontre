<?php
namespace app;
session_start();

require "../app/model/Autoloader.php";
autoloader::register();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 'login';
}

$auth = new Auth(new Db());

if (!$auth->logged()){
    if ($page === "login")
    {
        require "../app/views/login.php";
        require "../app/controller/ControllerLogin.php";
        $login = new controllerLogin();
        $login -> checkLogin();
    }
    elseif ($page === "register")
    {
        require "../app/controller/ControllerLogin.php";
        require "../app/views/inscription.php";
        $register = new controllerLogin();
        $register ->register();
    }
    elseif ($page === "postRegister")
    {
        require "../app/controller/ControllerLogin.php";
        require "../app/views/postInscriptionDetails.php";
        $postRegister = new controllerLogin();
        $postRegister ->postRegister();
    }
}
elseif ($auth->logged())
{
    if ($auth->logged() === 1){
        ob_start();
        if ($page === "accueil")
        {
            require "../app/controller/ControllerAccueil.php";
            $accueil = new controllerAccueil();
            $accueil->searchCondition();
            $accueil->like();
            $accueil->disLike();
            $accueil->searchProfil();
        }
        elseif ($page === "tchat")
        {
            require "../app/controller/ControllerTchat.php";
            $tchat = new ControllerTchat();
            $tchat->showMatchProfil();
            $tchat->showAllMessage();
        }
        elseif ($page === "deleteMatch")
        {
            require "../app/controller/ControllerTchat.php";
            $deleteMatch = new ControllerTchat();
        }
        elseif ($page === "profil")
        {
            require "../app/controller/ControllerParam.php";
            $Param = new controllerParam();
            $Param->updateParam();
            $Param->updateSearch();
            $Param->showParamProfil();
            $Param->deleteProfil();
        }
        elseif ($page === "updateSearch"){
            require "../app/controller/ControllerParam.php";
            $searchParam = new controllerParam();
            $searchParam->updateSearch();
        }
        elseif ($page === "disconnected")
        {
            require "../app/controller/ControllerLogin.php";
            $disconnected = new controllerLogin();
            $disconnected->disconnected();
        }
        $_SESSION['content'] = ob_get_clean();
        require "../app/controller/ControllerHeader.php";
        $allMatch = new ControllerHeader();
        $allMatch->allMatch();
    }
    elseif ($auth->logged() === 2)
    {
        ob_start();
        if ($page === "admin")
        {
            require "../app/controller/ControllerAdmin.php";
            $admin = new ControllerAdmin();
            $admin->AllUsers();
        }
        elseif ($page === "viewProfil")
        {
            require "../app/controller/ControllerAdmin.php";
            $viewProfil = new ControllerAdmin();
            $viewProfil->viewProfil();
        }
        elseif ($page === "deleteUser")
        {
            require "../app/controller/ControllerAdmin.php";
            $deleteUser = new ControllerAdmin();
            $deleteUser->deleteUser();
        }
        elseif ($page === "tchat")
        {
            require "../app/controller/ControllerTchat.php";
            $tchat = new ControllerTchat();
            $tchat->showMatchProfil();
            $tchat->showAllMessage();
        }
        elseif ($page === "sendMessage")
        {
            require "../app/controller/ControllerTchat.php";
            $send = new ControllerTchat();
            $send->sendMessage();
        }
        elseif ($page === "profilAdmin")
        {
            require "../app/controller/ControllerParam.php";
            $showParam = new controllerParam();
            $showParam->showParamProfilAdmin();
        }
        elseif ($page === "updateProfilAdmin"){
            require "../app/controller/ControllerParam.php";
            $updateParam = new controllerParam();
            $updateParam->updateParamAdmin();
        }
        elseif ($page === "disconnected")
        {
            require "../app/controller/ControllerLogin.php";
            $disconnected = new controllerLogin();
            $disconnected->disconnected();
        }
        $_SESSION['content'] = ob_get_clean();
        require "../app/controller/ControllerHeader.php";
        $allMatch = new ControllerHeader();
        $allMatch->allMatch();
    }
}