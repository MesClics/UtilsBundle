window.addEventListener("load", function(event){
    let popupBtns = event.target.querySelectorAll(".oocss-open-popup");
    for(let i = 0; i < popupBtns.length; i++){
        let popupBtn = popupBtns[i];
        let path = popupBtn.dataset.popupPath;
        popupBtn.addEventListener("click", function(e){
            e.preventDefault();
            //activate loader
            loaderClassAdd();
            ajaxGet(path, buildPopup);
        })
    }
});

function buildPopup(response){
    // include popup
    let popupNode = document.createElement("template");
    popupNode = response.trim();
    //close loader
    loaderClassRemove(true);
    // console.log(popupNode.firstChild);
    document.querySelector(".flash-messages").insertAdjacentHTML('beforebegin', popupNode);
    // relaod closeParent.js listenCloseBtns() function
    listenCloseBtns();
}