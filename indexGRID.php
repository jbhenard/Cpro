<!DOCTYPE html>
<html>
	<head>	
	<title id='Description'>This example shows how to create a Grid from Array data.</title>
    <link rel="stylesheet" href="jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />    
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxdata.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.selection.js"></script>
	<script>
		$(document).ready(function () {
		    // prepare the data
		    var source = {
		        datatype: "json",
		        datafields:
		        [
		        	{ name: 'CompanyName' },
		        	{ name: 'ContactName' },
		        	{ name: 'ContactTitle' },
		        	{ name: 'Address' },
		        	{ name: 'City' }
		        ],
		        url: 'data.php'
		    };
		    
		    $("#jqxgrid").jqxGrid({
		        source: source,
		        theme: 'classic',
		        columns: [{ text: 'Company Name', datafield: 'CompanyName', width: 250 },{ text: 'ContactName', datafield: 'ContactName', width: 150 },{ text: 'Contact Title', datafield: 'ContactTitle', width: 180 },{ text: 'Address', datafield: 'Address', width: 200 },{ text: 'City', datafield: 'City', width: 120 }]
		    });
		});
	</script>		
	</head>
	
	<body class='default'>
    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div id="jqxgrid"></div>
    </div>	
	</body>
</html>