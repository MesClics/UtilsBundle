window.addEventListener("load", function () {
    handleAddHtmlOnClick();
});

function handleAddHtmlOnClick(){
    let btns = document.querySelectorAll(".oocss-html-adder");

    for (let index = 0; index < btns.length; index++) {
        let btn = btns[index];
        
        
        let target = document.querySelector(btn.dataset.targetSelector);

        let path = btn.dataset.path;
        
        let callback = function(response) {
            let htmlNode = document.createElement("template");
            htmlNode = response.trim();

            target.insertAdjacentHTML('beforeend', htmlNode);
        }

        btn.addEventListener("click", function(){
            ajaxGet(path, callback);
        });
    }
}

