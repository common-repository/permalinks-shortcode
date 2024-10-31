"use strict";

window.onload=function() {

    /**
     * init variables
     */
    var p;
    var targetValue;
    var checkedValue;
    var textValue;
    var target = "_self";

    /**
     * Get element
     * @type {HTMLElement}
     */
    p = document.getElementById("posts_list");
    textValue = document.getElementById("textvalue");
    checkedValue = document.querySelector('#open_new_window');


    /**
     * listen events on select
     */
    if (p) {
        p.addEventListener('change', function () {
            shortCodeUpdate();
        }, false);
    }


    /**
     * listen events on textValue
     */
    if (textValue) {
        textValue.addEventListener('change', function () {
            shortCodeUpdate();
        }, false);
    }


    /**
     * listen events on checkedValue
     */
    if (checkedValue) {
        checkedValue.addEventListener('click', function () {
            shortCodeUpdate();
        }, false);
    }

    var result = document.getElementById("shortcode_generated");

    if (result) {
        result.addEventListener('click', function () {
            selectText('shortcode_generated');

        }, false);
    }

    function selectText(id) {
        var sel, range;
        var el = document.getElementById(id); //get element id

        //console.log(el);

        if (window.getSelection && document.createRange) { //Browser compatibility
            sel = window.getSelection();
            if (sel.toString() == '') { //no text selection
                window.setTimeout(function () {
                    range = document.createRange(); //range object
                    range.selectNodeContents(el); //sets Range
                    sel.removeAllRanges(); //remove all ranges from selection
                    sel.addRange(range);//add Range to a Selection.
                }, 1);
            }
        } else if (document.selection) { //older ie
            sel = document.selection.createRange();
            if (sel.text == '') { //no text selection
                range = document.body.createTextRange();//Creates TextRange object
                range.moveToElementText(el);//sets Range
                range.select(); //make selection.
            }
        }
    }

    function shortCodeUpdate() {

        var type;
        target = "_self";

        textValue = document.getElementById("textvalue");
        targetValue = p.options[p.selectedIndex].value;
        checkedValue = document.querySelector('#open_new_window').checked;

        //var article = document.getElementById('voitureelectrique');

        type = p.options[p.selectedIndex].dataset.type;

        targetValue = parseInt(targetValue);

        if (textValue) {
            textValue = textValue.value;
        }

        if (checkedValue) {
            target = "_blank";
        }

        if (Number.isInteger(targetValue)) {

            var div = document.getElementById('shortcode_generated');

            div.innerHTML = '[permalink wpid="' + targetValue + '" type="' + type + '" target="' + target + '"]';
            div.innerHTML += textValue;
            div.innerHTML += '[/permalink]';
        }

    }

}