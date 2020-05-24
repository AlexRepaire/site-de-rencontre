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
let input = $("#input_txt");

function getMessages() {
    $.ajax({
        type: "GET",
        url: 'app/ajax/chargeContent.php?id='+convId +'&idUser='+idUser,
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

function postMessage() {
    const message = input.val();
    input.val("").focus();
    $.ajax({
        type: "POST",
        url: "app/ajax/insertContent.php",
        data: "id="+convId +"&idUser="+idUser +"&message="+message
    }).done(function () {
        getMessages();
    });
    return false;
}
