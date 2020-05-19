$("#matchsBtn").click(function () {
    $("#page_tchat").toggle();
});

$("#showProfil").click(function () {
    $("#tchat").toggle();
    $("#matchProfileTchat").toggle();
})

$("#retour").click(function () {
    $("#tchat").toggle();
    $("#matchProfileTchat").toggle();
})

let getMessageTimeout;
const container = $("#all_messages");

function getMessages() {
    $.ajax({
        type: "GET",
        url: '../app/ajax/chargeContent.php?id='+convId +'&idUser='+idUser,
        //si success
    }).done(function (data) {
        container.html(data);
        //permet de défiler la scrollbar vers le bas
        container.scrollTop(container.height());

        if (getMessageTimeout){
            clearTimeout(getMessageTimeout);
        }
        getMessageTimeout = setTimeout(function () {
            getMessages();
        },5000);
    })
}
getMessages();

const message = $("#input_txt");
function postMessage() {
    $.ajax({
        type: "POST",
        url: "../app/ajax/insertContent.php",
        data: "id="+convId +"&idUser="+idUser +"&message="+message.val()
    }).done(function () {
        getMessages();
    });
    return false;
}
