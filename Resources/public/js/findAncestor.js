// Find the closest ancestor of el with class cls

function findAncestor(el, cls) {
    while ((el = el.parentElement) && !el.classList.contains(cls));
    return el;
}

function findNearest(el, cls) {
    while ((el = el.parentElement) && !el.querySelector(cls));
    return el;
}