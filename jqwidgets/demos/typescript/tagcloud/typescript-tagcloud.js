/// <reference path="../../app/jqwidgets-ts/jqwidgets.d.ts" />
function createTagCloud(selectorAdapter, selectorTagCloud) {
    var data = [
        { countryName: "Australia", technologyRating: 35 },
        { countryName: "United States", technologyRating: 60 },
        { countryName: "Germany", technologyRating: 55 },
        { countryName: "Brasil", technologyRating: 20 },
        { countryName: "United Kingdom", technologyRating: 50 },
        { countryName: "Japan", technologyRating: 80 }
    ];
    var source = {
        localdata: data,
        datatype: "array",
        datafields: [
            { name: 'countryName' },
            { name: 'technologyRating' }
        ]
    };
    var dataAdapter = new $.jqx.dataAdapter(source, {});
    // creates an instance
    //var myDataAdapter: jqwidgets.jqxDataAdapter = jqwidgets.createInstance(selectorAdapter, 'jqxDataAdapter');
    //var datAdapter = myDataAdapter(source, {});
    //console.log('ok');
    //var myDataAdapter: jqwidgets.jqxDataAdapter = jqwidgets.createInstance(selectorAdapter, 'jqxDataAdapter');
    //var dataAdapter = myDataAdapter(source);
    //var dataAdapter = new $.jqx.dataAdapter(source, {});
    // initialization options - validated in typescript
    var options = {
        width: '600px',
        source: dataAdapter,
        displayMember: 'countryName',
        valueMember: 'technologyRating'
    };
    //creates an instance
    var tagCloudInstance = jqwidgets.createInstance(selectorTagCloud, 'jqxTagCloud', options);
}
//# sourceMappingURL=typescript-tagcloud.js.map