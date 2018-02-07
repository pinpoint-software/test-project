/* Register event handlers */
$(document).ready(function() {
    $('#url').keyup(inputHandler);
    $('#userText').keyup(inputHandler);
    $('#link-submit-btn').mouseover(linkBtnHandler);
});

var userWarnUrl = "Sorry to bother you like this, but we thought that you might "
                + "like to know that, since there is already text entered into the "
                + "'Text' field below, anything you enter here will be ignored. "
                + "Unless, of course, you click on the 'Create Both Links' "
                + "button below.";
var userWarnText = "We can't help but notice that you have already typed something "
                + "into the URL field above. That field will be ignored unless you "
                + "click the 'Create Both Links' button below.";
/*
 *  inputHandler()
 *
 *      Called on keyup for both the 'url' input and the 'userText' input. If
 *      the user has not yet been warned (and there is text in both the url
 *      and userText fields), it will display a message relevent to whichever
 *      field that the user is currently entering text into.
 *
 *      It will also fade in or out the 'Create Both Links' button based on if
 *      the user has been warned and whether or not there is still text in both
 *      the 'url' and 'userText' fields
 *
 *  @returns: None
 */
function inputHandler(ev) {

    var target = ev.target.id;

    // ensure that the user isn't repeatedly warned about the consequences of
    // not clicking the button
    if (typeof inputHandler.haveWarned == 'undefined') {
        inputHandler.haveWarned= false;
    }

    if (textAndUrlValsNotNull() && (target === 'url')
            && !inputHandler.haveWarned) {
        alert(userWarnUrl);
        inputHandler.haveWarned = true;
    } else if (textAndUrlValsNotNull() && (target === 'userText')
            && !inputHandler.haveWarned) {
        alert(userWarnText);
        inputHandler.haveWarned = true;
    }

    if(inputHandler.haveWarned && textAndUrlValsNotNull()) {
        fadeElement('dual-create-btn-div', 2000, 'in');
    } else {
        fadeElement('dual-create-btn-div', 2000, 'out');
    }
}
/*
 *  linkBtnHandler()
 *
 *      Called on mouseover of the submit button. Currently it only validates
 *      the url if entered.
 *
 *  @returns: None
 */
function linkBtnHandler(ev) {

    // validate the url if there is one 
    var url = $('#url').val();
    var badUrlMsg = "The URL:       " + url + "\nappears to be invalid.\n\n"
                    + "The url must be formatted as such:"
                    + "\n\nhttp[s]://[www.]example.com[/path]\n\n"
                    + "where the values in brackets are optional.\nPlease reformat "
                    + "your url.";
    if(url) {
        var goodUrl = validateUrl(url);
        if (!goodUrl) {
            alert(badUrlMsg);
        }
    }
}

/*
 *      Helper Functions
 */

/*
 *  validateUrl()
 *
 *     If the url matches, it will return an array of the following:
 *
 *          Index                   Value
 *
 *          0.......................The full string given
 *          1.......................The protocol, either http:// or https://
 *                                  This capture is required.
 *          2.......................The 'www' if it was provided in the url
 *          3.......................This will always be the parent domain to the
 *                                  'www' sub-domain. In the case where index 4
 *                                  is undefined, this will be the 2nd level
 *                                  domain name.
 *                                  At least one of these captures are required.
 *          4.......................If this is defined, it will always be the
 *                                  2nd level domain name.
 *          5.......................The top level domain. This capture is
 *                                  required, as well.
 *          6.......................The Port
 *          7.......................The Path
 *
 *      Captures that don't match will be undefined.
 *
 *      Returns null if the url doesn't at least match an http or https protocol,
 *      a domain, and something that looks like a tld.
 *
 * @param: string url - The url to validate
 * @returns: An array or null
 */
function validateUrl(url) {
    var ret =  url.match(
            // capture the protocol
            // it should match one and only one of http(s)
            // this is one of the required matches
            "^(http:\/\/|https:\/\/){1}"
            // with or without the www
            + "(www\.)?"
            // capture the 3rd level domain name if it's here
            + "([a-z0-9]*)*"
            // followed by the 2nd level domain name
            // but also allow to match any possible number of subdomains
            // ...matching at least one is required
            + "([\-\.]{1}[a-z0-9]+)*"
            // followed by a final . and whatever tld is used (also required)
            + "\.([a-z]{2,5})"
            // any possible port numbers
            + "(:[0-9]{1,5})?"
            // and lastly, capture any possible path
            + "(\/.*)?$");
    return ret;
}

/*
 *  textAndUrlValsNotNull()
 *
 *      Returns true if both the 'Text' and 'URL' input fields contain a value.
 *      False otherwise.
 *
 * @returns: boolean
 */
function textAndUrlValsNotNull() {
    return $('#url').val() && $('#userText').val();
}

/*
 *  fadeElement()
 *
 *      Calls $.fade[In|Out]() on an element.
 *
 * @param: string id - The markup id of the desired element
 * @param: integer delta - The duration of the fade (in ms)
 * @param: string direction - 'in' if the element should be faded in, any other
 *                            value will default to fadeOut()
 * @returns: none
 */
function fadeElement(id, delta, direction) {
    if (direction === "in") {
        $("#" + id).fadeIn(delta);
    } else {
        $("#" + id).fadeOut(delta);
    }
}
