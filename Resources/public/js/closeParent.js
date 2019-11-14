window.addEventListener("load", function () {
    listenCloseBtns();
});

function listenCloseBtns(){
    let closeBtns = document.querySelectorAll(".oocss-close");
    if (closeBtns.length) {
        for (let i = 0; i < closeBtns.length; i++) {
            let btn = closeBtns[i];

            btn.addEventListener("click", function (event) {
                event.preventDefault;
                let cls = event.target.getAttribute("data-target-class");
                btnContainer = findAncestor(event.target, cls);
                //restart animations
                event.target.animationPlayState = "running";
                btnContainer.classList.add("oocss-closed");
            });
        }
    }
}