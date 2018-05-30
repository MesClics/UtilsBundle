const addBtns = document.querySelectorAll('.oocss-js-dynamic-button');

//on définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
var index = 0;

function addField(parentNode) {
    var dynamicField = parentNode.querySelector('.oocss-js-dynamic-template');
    var targetDiv = parentNode.querySelector('.oocss-js-dynamic-target');

    var dataPrototype = dynamicField.getAttribute('data-prototype');
    var dataClass = dynamicField.getAttribute('data-class');
    var field = dataPrototype.replace(/__name__/g, index.toString());

    //on ajoute le champ modifié à la fin de la balise
    var newDiv = document.createElement('div');
    newDiv.innerHTML += field;
    newDiv.classList = dataClass;

    targetDiv.appendChild(newDiv);
    //on incrémente le compteur de champs dynamiques
    index++;
}

addBtns.forEach(function(addBtn){
    addBtn.addEventListener('click', function (e) {
        //on désactive la cible du "lien"
        e.preventDefault();
        //on récupère le noeud parent :
        parentNode = addBtn.parentNode;
        //on ajoute un nouveau champ
        addField(parentNode);
    });
});