var slideshows = document.querySelectorAll(".oocss-slideshow");

var currentStep = 0;

slideshows.forEach(function(slideshow){
    var steps = slideshow.querySelectorAll(".oocss-slideshow-step");
    // console.log(steps);
    var len = steps.length;
    var slideshowContent = slideshow.querySelector(".oocss-slideshow-content");
    slideshowContent.style.setProperty("--steps-nb", len);

    var cursor = slideshow.querySelector(".oocss-cursor");



    prevBtn = slideshow.querySelector(".oocss-prev");
    prevBtn.addEventListener("click", function (e) {
        console.log("Click on prev");
        e.preventDefault();
        //update currentStep value
        currentStep--;
        //get the current step tag
        steps[currentStep].focus();
    });

    nextBtn = slideshow.querySelector(".oocss-next");
    nextBtn.addEventListener("click", function (e) {
        console.log("click on next");
        e.preventDefault();
        //update currentStep value
        currentStep++;
        steps[currentStep].focus();
    });



    for (let i = 0; i < len; i++) {

        //si le slideshow est un formulaire (donc pas de défilement auto mais au focus), eventListener sur les inputs ou textarea ou select
        if(slideshow.classList.contains("oocss-form")){


            steps.addEventListener("focus", function (e) {
                e.preventDefault();
                e.target.parentElement.scrollLeft = 0;
            });


            var inputs = steps[i].getElementsByTagName('input', 'textarea', 'select', 'button');

           for(var inputIndex = 0; inputIndex < inputs.length; inputIndex++){
               inputs[inputIndex].addEventListener('focus', function (e) {
                   //si le step est le premier du slideshow cacher le bouton previous step
                   if (i === 0) {
                       prevBtn.style.display = "none";
                   } else{
                       prevBtn.style.display = "block";
                   }

                   if (i === len) {
                       nextBtn.style.display = "none";
                   } else{
                       nextBtn.style.display = "block";
                   }

                //    console.log("focus on " + (i + 1) + "° slideshow step");

                   turnCursorItemActive(i, cursor);
                    //change value of oocss-slideshow-content css-variable past-steps-nb
                    slideshowContent.style.setProperty("--past-steps-nb", i);
                    // console.log(window.getComputedStyle(slideshowContent).getPropertyValue("transform"));
               });
           }
        }

        else{
            console.log("slideshow auto. TODO: écrire script de défilement auto");
        }
    }
});

function turnCursorItemActive(activeCursorItemIndex, cursor){
    cursorItems = cursor.querySelectorAll('.oocss-cursor-item');

    for(var i = 0; i < cursorItems.length; i++){
        if(i !== activeCursorItemIndex){
            cursorItems[i].classList.remove('active');
        } else if(!cursorItems[i].classList.contains('active')){
            cursorItems[i].classList.add('active');
        }
    }
}