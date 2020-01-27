    window.addEventListener("load", function(){
    console.log("html modifier loaded");

    listenHTMLModifyBtns();
})

function listenHTMLModifyBtns(){
    let btns = document.querySelectorAll(".oocss-html-modifier");

    for (let index = 0; index < btns.length; index++) {
        let btn = btns[index];



        //if admin get scroll into desk-main container, else get scroll into document
        if (document.querySelector(".desk-main")) {
            var scroll = [document.querySelector(".desk-main").scrollLeft, document.querySelector(".desk-main").scrollTop];
        } else {
            var scroll = [document.documentElement.scrollLeft, document.documentElement.scrollTop];
        }


        btn.addEventListener("click", function(e){
            modifyHTML(e.target);

            document.addEventListener("load", function(){
                console.log(scroll);
                if (document.querySelector(".desk-main")) {
                    var scrollContainer = document.querySelector(".desk-main");
                } else {
                    var scrollContainer = document.documentElement;
                }

                scrollContainer.pageXOffset = scroll[0];
                scrollContainer.pageYOffset = scroll[1];
            });
        });
    }
}

// if the element gets a data-target-selector, then it will replace innerHTML by the ajax returning response, else it will reload the current page after returning the ajax response
function modifyHTML(element){
    let path = element.dataset.path;
    let target = document.querySelector(element.dataset.targetSelector);
    let callback = function (response) {
        if(target){
            // let htmlNode = document.createElement("template");
            let htmlNode = response.trim();
            // console.log(target);
            target.innerHTML = htmlNode;
        } else{
            if (response) {
                document.location.reload(true);
            }
        }
    }

    ajaxGet(path, callback);
}