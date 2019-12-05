var clickableTableRows = document.querySelectorAll(".oocss-clickable-table-row");

for(let i = 0; i < clickableTableRows.length; i++){
    let clickableTableRow = clickableTableRows[i];
    let link = clickableTableRow.getAttribute("data-link");

    // let link = clickableTableRow.getElementsByTagName("a")[0].getAttribute("href");

    if(link) {
        let tds = clickableTableRow.querySelectorAll(".oocss-table-data");

        for(let i = 0; i < tds.length; i++){
            let clickableTableData = tds[i];

            let linksOrButtons = clickableTableData.querySelectorAll("a,button");
            if (linksOrButtons.length == 0) {
                //if child is not a link or button
                clickableTableData.addEventListener("click", function (e) {
                    window.location.href = link;
                });

            }
        }
    }
}

