const filterSearch = document.querySelector('[table-filter="search"]');
filterSearch.addEventListener("keyup", function (e) {
    window.LaravelDataTables[`${tableId}`].search(e.target.value).draw();
});
