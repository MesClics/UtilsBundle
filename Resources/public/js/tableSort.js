function sortTables() {

    let toggleOrder = function toggleOrder(elt) {
        let ascRegex = /asc$/gi;
        let descRegex = /desc$/gi;
        let nullRegex = /null$/gi;
        if (elt.dataset.sort && elt.dataset.sort.match(ascRegex)) {
            elt.dataset.sort = elt.dataset.sort.replace(ascRegex, 'DESC');
            if(elt.classList.contains('sort-ASC')){
                elt.classList.remove('sort-ASC');
            }
            elt.classList.add('sort-DESC');
        } else if (elt.dataset.sort && elt.dataset.sort.match(descRegex)) {
            elt.dataset.sort = elt.dataset.sort.replace(descRegex, 'ASC');
            if(elt.classList.contains('sort-DESC')){
                elt.classList.remove('sort-DESC');
            }
            elt.classList.add('sort-ASC');
        } else if (elt.dataset.sort && elt.dataset.sort.match(nullRegex)) {
            elt.dataset.sort = elt.dataset.sort.replace(nullRegex, 'ASC');
            if(elt.classList.contains('sort-DESC')){
                elt.classList.remove('sort-DESC');
            }
            elt.classList.add('sort-ASC');
        }
    }

    let toggleActiveClass = function toggleActiveClass(elt){
        // get "siblings"
        let activeSibling = elt.closest('.oocss-table-head-row').querySelector('.oocss-active');
        activeSibling.classList.remove('oocss-active');
        elt.classList.add('oocss-active');

        return activeSibling.dataset.sort;
    }

    function replacePageButtonsLinks(orderBy, order, table){
        let pageButtons = table.querySelectorAll('.page-button');

        for(let pageButton of pageButtons){
            let page = pageButton.textContent;
            let url = pageButton.href.split("?")[0];
            url += "?html=true&page=" + page + "&order-by=" + orderBy+"&order=" + order;
            pageButton.href = url;
        }
    }

    function replaceDatasInTable(html, table){
        let datasTag = table.querySelector('.oocss-table-datas');
        datasTag.innerHTML = html;
    }

    let tables = document.querySelectorAll('.oocss-table');

    let orderColOnClick = function(colHead, table){
        colHead.addEventListener('click', function(e){
            e.preventDefault();
            toggleOrder(e.target);
            //add class active and remove from "siblings"
            let previousOrder = toggleActiveClass(e.target);
            let previousOrderBy = previousOrder.split('|')[0];
            previousOrder = previousOrder.split('|')[1];
            let orderBy = e.target.dataset.sort.split('|')[0];
            let order = e.target.dataset.sort.split('|')[1];
            //get datas
            let rows = table.querySelectorAll('.oocss-table-row');
            //oder datas according to col and ASC or DESC
            // if(orderBy is same as previousOrderBy get order get page nb)
            if(orderBy === previousOrderBy){
                var currentPage = document.querySelector('.current-page');
                if(currentPage){
                    currentPage = currentPage.textContent;
                }
            } else{
                var currentPage = 1;
            }
            let url = table.dataset.link + "?html=true&page=" + currentPage + "&order-by=" + orderBy+"&order=" + order;
            replacePageButtonsLinks(orderBy, order, table);

            ajaxGet(url, function(jsonResponse){
                let html = JSON.parse(jsonResponse).results;
                replaceDatasInTable(html, table);
                // reactivate filters
                activateFilters();
            })
        });
    }
    for(let table of tables){
        //get orderables cols
        let orderableCols = table.querySelectorAll('[data-sort]');
        for(let col of orderableCols){
            orderColOnClick(col, table);
        }
    }
}
window.addEventListener('load', sortTables());