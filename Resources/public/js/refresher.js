window.addEventListener("load", function(event){
    let refreshBtns = document.querySelectorAll(".oocss-refresher");

    for (let index = 0; index < refreshBtns.length; index++) {
        let element = refreshBtns[index];
        
        element.addEventListener("click", function(e){
            let btn = e.target;
            //if admin get scroll into desk-main container, else get scroll into document
            if(document.querySelector(".desk-main")){
                var scroll = [document.querySelector(".desk-main").scrollLeft, document.querySelector(".desk-main").scrollTop];
            } else{
                var scroll = [document.documentElement.scrollLeft, document.documentElement.scrollTop];
            }

            refresh(btn, scroll);
        });
    }
});

function refresh(element, scroll = null) {

    //reload, widget and preserve scroll
    let path = element.dataset.path;

    // execute ajaxGet on container if data-target-selector is specified
    if (element.dataset.targetSelector) {
        ajaxGet(path, function (response) {
            let htmlNode = document.createElement("template");
            htmlNode = response.trim();

            htmlNode = stringToHTMLDoc(htmlNode);

            // Get the container content into the response
            replace(element.dataset.targetSelector, htmlNode);
        });
    } else{
        window.location = path;
    }
}


function replace(containerSelector, newHTMLDocument, scroll){
    let old_elt = document.querySelector(containerSelector);
    let new_elt = newHTMLDocument.querySelector(containerSelector);

    if(old_elt){
        let eltParent = old_elt.parentNode;
        eltParent.appendChild(new_elt);
        old_elt.remove();
    }
    // elt.replaceWith(newHTMLContent);

    if(scroll){

        if (document.querySelector(".desk-main")) {
            var scrollContainer = document.querySelector(".desk-main");
        } else {
            var scrollContainer = document.documentElement;
        }        
        scrollContainer.pageXOffset = scroll[0];
        scrollContainer.pageYOffset = scroll[1];
    }
}

function stringToHTMLDoc(str){
    var parser = new DOMParser();
    var doc = parser.parseFromString(str, 'text/html');
    return doc;
}