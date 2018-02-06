$(document).ready(function() {
    $('#url').keypress(urlInputHandler);
    $('#userText').keypress(textInputHandler);
});

function urlInputHandler() {

    textBox = $('#userText').val();
    if (typeof urlInputHandler.haveWarned == 'undefined' ) {
        urlInputHandler.haveWarned = false;
    }

    if (textBox !== "" && !urlInputHandler.haveWarned) {
        alert("Sorry to bother you like this, but we thought that you might like to know"
                + " that, since there is alreaady text entered into the 'Text' field, anything you enter here"
                + " will be ignored. Unless you click on the 'Create Both Links' button below.");
        urlInputHandler.haveWarned = true;
        
    }

    if(urlInputHandler.haveWarned) {
        $('#dual-create-btn-div').fadeIn(2000);
    }
}

function textInputHandler() {

    urlBox = $('#url').val();
    if (typeof textInputHandler.haveWarned == 'undefined' ) {
        textInputHandler.haveWarned = false;
    }

    if (urlBox !== "" && !textInputHandler.haveWarned) {
        alert("We can't help but notice that you have typed something into the URL field."
                + " Please note, that unless you click the 'Create Both Links' button, only a link"
                + " to the text will be created.");
        textInputHandler.haveWarned = true;
    }

    if(textInputHandler.haveWarned) {
        $('#dual-create-btn-div').fadeIn(2000);
    }
}
