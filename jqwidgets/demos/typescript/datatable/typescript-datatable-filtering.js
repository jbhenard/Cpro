/// <reference path="../../app/jqwidgets-ts/jqwidgets.d.ts" />
function createDataTableFiltering(selector) {
    var source = {
        dataType: "xml",
        dataFields: [
            { name: 'SupplierName', type: 'string' },
            { name: 'Quantity', type: 'number' },
            { name: 'OrderDate', type: 'date' },
            { name: 'OrderAddress', type: 'string' },
            { name: 'Freight', type: 'number' },
            { name: 'Price', type: 'number' },
            { name: 'City', type: 'string' },
            { name: 'ProductName', type: 'string' },
            { name: 'Address', type: 'string' }
        ],
        url: '../../sampledata/orderdetailsextended.xml',
        root: 'DATA',
        record: 'ROW'
    };
    var dataAdapter = new $.jqx.dataAdapter(source, {
        loadComplete: function () {
            // data is loaded.
        }
    });
    // initialization options - validated in typescript
    // jqwidgets.DataTableOptions has generated TS definition
    var options = {
        source: dataAdapter,
        pageable: true,
        altRows: true,
        filterable: true,
        width: 850,
        columns: [
            { text: 'Supplier Name', cellsAlign: 'center', align: 'center', dataField: 'SupplierName', width: 250 },
            { text: 'Name', cellsAlign: 'center', align: 'center', dataField: 'ProductName', width: 250 },
            { text: 'Quantity', dataField: 'Quantity', cellsFormat: 'd', cellsAlign: 'center', align: 'center', width: 120 },
            { text: 'Price', dataField: 'Price', cellsFormat: 'c2', align: 'center', cellsAlign: 'center', width: 120 },
            { text: 'City', cellsAlign: 'center', align: 'center', dataField: 'City' }
        ]
    };
    // creates an instance
    var myDataTable = jqwidgets.createInstance(selector, 'jqxDataTable', options);
}
//# sourceMappingURL=typescript-datatable-filtering.js.map