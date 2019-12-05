
function handleTableGrids(){
    let tables = document.querySelectorAll('.oocss-table');

    for(let i = 0; i< tables.length; i++){
        let table = tables[i];

        let tableCols = table.querySelectorAll('.oocss-table-head');
        let tableColsNb = tableCols.length;

        let tableColsTemplate = [];

        for(let y = 0; y < tableColsNb; y++){
            let col = tableCols[y];
            let hasColWidth = col.dataset.columnWidth;
            if(hasColWidth){
                tableColsTemplate.push(hasColWidth);
            } else{
                tableColsTemplate.push('minmax(auto, 1fr)');
            }
        }
        // console.log(tableColsTemplate);

        table.style.setProperty('--cols-nb', tableColsNb);
        tableColsTemplate = tableColsTemplate.join(" ");
        table.style.setProperty('--cols-template', tableColsTemplate);
    }
}

window.addEventListener("load", function(){
    handleTableGrids();
});