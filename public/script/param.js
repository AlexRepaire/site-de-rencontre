//MENU NAVIGATION PARAM

$("#comptebtn").click(function () {
    $("#gestionProfil").show();
    $("#parametreDeRecherche").hide();
    $("#contact").hide();
});

$("#recherchebtn").click(function () {
    $("#gestionProfil").hide();
    $("#parametreDeRecherche").show();
    $("#contact").hide();
});

$("#contactbtn").click(function () {
    $("#gestionProfil").hide();
    $("#parametreDeRecherche").hide();
    $("#contact").show();
});


$("#matchsBtn").click(function () {
    $("#page_profil").toggle();
});


//Prévisualisation photo

function previewFile() {
    var preview = document.getElementById('img');
    var file    = document.querySelector('input[type=file]').files[0];
    var reader  = new FileReader();

    reader.addEventListener("load", function () {
        preview.src = reader.result;
    }, false);

    if (file) {
        reader.readAsDataURL(file);
    }
}
