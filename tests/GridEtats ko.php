<!DOCTYPE html>
<html lang="en">
<head>
<title id='Description'>In order to enter in edit mode, select a grid row, then "Click" or press the "F2" key. To cancel the editing, press the "Esc" key. To save
    the changes press the "Enter" key or select another Grid row.</title>
    <link rel="stylesheet" href="http://cpro.jbh/jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="http://cpro.jbh/jqwidgets/jqwidgets/styles/jqx.classic.css" type="text/css" />

    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxdata.js"></script> 
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxgrid.edit.js"></script>  
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/scripts/demos.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/demos/jqxgrid/generatedata.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxexpander.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxdragdrop.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/jqwidgets/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="http://cpro.jbh/tests/generatedata.js"></script>
    
    <script type="text/javascript">
    	$(document).ready(function () {
    		// prepare the data            
            var data = {};
            var theme = 'classic';
            var firstNames = ["Nancy", "Andrew", "Janet", "Margaret", "Steven", "Michael", "Robert", "Laura", "Anne"];
            var lastNames = ["Davolio", "Fuller", "Leverling", "Peacock", "Buchanan", "Suyama", "King", "Callahan", "Dodsworth"];
            var titles = ["Sales Representative", "Vice President, Sales", "Sales Representative", "Sales Representative", "Sales Manager", "Sales Representative", "Sales Representative", "Inside Sales Coordinator", "Sales Representative"];
            var address = ["507 - 20th Ave. E. Apt. 2A", "908 W. Capital Way", "722 Moss Bay Blvd.", "4110 Old Redmond Rd.", "14 Garrett Hill", "Coventry House", "Miner Rd.", "Edgeham Hollow", "Winchester Way", "4726 - 11th Ave. N.E.", "7 Houndstooth Rd."];
            var city = ["Seattle", "Tacoma", "Kirkland", "Redmond", "London", "London", "London", "Seattle", "London"];
            var country = ["USA", "USA", "USA", "USA", "UK", "UK", "UK", "USA", "UK"];
            
        var generaterow = function (id) {
            var row = {};
            var firtnameindex = Math.floor(Math.random() * firstNames.length);
            var lastnameindex = Math.floor(Math.random() * lastNames.length);
            var k = firtnameindex;
            row["Clef"] = id;
            row["Champ"] = "état";
            row["Valeur"] = "saisir";
            row["Mail"] = "saisir";
            row["Sequence"] = "saisir";
            
            return row;
        }
        
    	var getAdapter = function () {
            var source = {
                datatype: "json",                 
                cache: false,
                datafields: [
					 { name: 'Clef', type: 'string' },
					 { name: 'Champ', type: 'string' },
					 { name: 'Valeur', type: 'string' },
					 { name: 'Mail', type: 'string' },
					 { name: 'Sequence',type: 'string' }					 
                ],
                id: 'Clef',
                url: 'dataMaJ.php',                
                addrow: function (rowid, rowdata, position, commit) {
                    // synchronize with the server - send insert command
                    var data = "insert=true&" + $.param(rowdata);
                    $.ajax({
                        dataType: 'json',
                        url: 'dataMaJ.php',
                        data: data,
                        cache: false,
                        success: function (data, status, xhr) {
                            // insert command is executed.
                            commit(true);
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            commit(false);
                        }
                    });
                },                                
                deleterow: function (rowid, rowdata, commit) {									
			    // synchronize with the server - send delete command									    	
			        var data = "delete=true&" + $.param(rowdata);
					$.ajax({				
			            dataType: 'json',						
			            url: 'dataMaJ.php',						
						cache: false,			
			            data: data,						
			            success: function (data, status, xhr) {						
							// delete command is executed.		
							commit(true);		
						},			
						error: function(jqXHR, textStatus, errorThrown)			
						{			
							commit(false);		
						}
					});
				},
                updaterow: function (rowid, rowdata, commit) {
                    	// synchronize with the server - send update command
	                    var data = "update=true&" + $.param(rowdata);
	                    $.ajax({
	                        dataType: 'json',
	                        url: 'dataMaJ.php',
	                        cache: false,
	                        data: data,
	                        success: function (data, status, xhr) {
	                            // update command is executed.
	                            commit(true);
	                        },
	                        error: function (jqXHR, textStatus, errorThrown) {
	                            commit(false);
	                        }
                    	});
                	}
            	};            
               	var dataAdapter = new $.jqx.dataAdapter(source);
            	return dataAdapter;
            }
                     
            // initialize jqxGrid
            $("#jqxgrid").jqxGrid(
            {
                width: 750,                
                editable: true,                
                selectionmode: 'singlecell',
                editmode: 'selectedrow',
                height: 350,
             	source: getAdapter(), 
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='http://cpro.jbh/jqwidgets/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='http://cpro.jbh/jqwidgets/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='http://cpro.jbh/jqwidgets/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                    var searchButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='http://cpro.jbh/jqwidgets/images/search.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Find</span></div>");
                    container.append(addButton);
                    container.append(deleteButton);
                    container.append(reloadButton);
                    container.append(searchButton);
                    statusbar.append(container);
                    addButton.jqxButton({  width: 60, height: 20 });
                    deleteButton.jqxButton({  width: 65, height: 20 });
                    reloadButton.jqxButton({  width: 65, height: 20 });
                    searchButton.jqxButton({  width: 50, height: 20 });
                    
                    // add new row.
                    addButton.click(function (event) {                    	
                		var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                		var datarow = generaterow(rowscount + 1);
                		$("#jqxgrid").jqxGrid('addrow', null, datarow);                		
                    });
                    
					// delete selected row.
                    deleteButton.click(function (event) {
                    	alert("row will be destroy!");
                        var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                        var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                        var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                        $("#jqxgrid").jqxGrid('deleterow', id);
                    });
                                                            
                    // reload grid data.
                    reloadButton.click(function (event) {
                        $("#jqxgrid").jqxGrid({ source: getAdapter() });
                    });
                    // search for a record.
                    searchButton.click(function (event) {
                        var offset = $("#jqxgrid").offset();
                        $("#jqxwindow").jqxWindow('open');
                        $("#jqxwindow").jqxWindow('move', offset.left + 30, offset.top + 30);
                    });
                },
                theme: theme,                
                pageable: true,
                autoheight: true,                
                columns: [
                      { text: 'Clef', columntype: 'textbox', datafield: 'Clef', width: 100, editable: false },
                      { text: 'Champ', columntype: 'textbox', datafield: 'Champ', width: 150 },
                      { text: 'Valeur', columntype: 'textbox', datafield: 'Valeur', width: 300 },
                      { text: 'Mail', columntype: 'textbox', datafield: 'Mail', width: 100 },
                      { text: 'Séquence', columntype: 'textbox', datafield: 'Sequence', width: 100 }                      
                  ]
            });
            
             // create jqxWindow.
            $("#jqxwindow").jqxWindow({ resizable: false,  autoOpen: false, width: 210, height: 180 });
            // create find and clear buttons.
            $("#findButton").jqxButton({ width: 70});
            $("#clearButton").jqxButton({ width: 70});
            // create dropdownlist.
            $("#dropdownlist").jqxDropDownList({ autoDropDownHeight: true, selectedIndex: 0, width: 200, height: 23, 
                source: [
                    'Clef', 'Paramètre', 'Valeur', 'Mail', 'Sequence'
                ]
            });

            if (theme != "") {
                $("#inputField").addClass('jqx-input-' + theme);
            }

            // clear filters.
            $("#clearButton").click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
            });

            // find records that match a criteria.
            $("#findButton").click(function () {
                $("#jqxgrid").jqxGrid('clearfilters');
                var searchColumnIndex = $("#dropdownlist").jqxDropDownList('selectedIndex');
                var datafield = "";
                switch (searchColumnIndex) {
                    case 0:
                        datafield = "Clef";
                        break;
                    case 1:
                        datafield = "Champ";
                        break;
                    case 2:
                        datafield = "Valeur";
                        break;
                    case 3:
                        datafield = "Mail";
                        break;
                    case 4:
                        datafield = "Sequence";
                        break;
                }

                var searchText = $("#inputField").val();
                var filtergroup = new $.jqx.filter();
                var filter_or_operator = 1;
                var filtervalue = searchText;
                var filtercondition = 'contains';
                var filter = filtergroup.createfilter('stringfilter', filtervalue, filtercondition);
                filtergroup.addfilter(filter_or_operator, filter);
                $("#jqxgrid").jqxGrid('addfilter', datafield, filtergroup);
                // apply the filters.
                $("#jqxgrid").jqxGrid('applyfilters');
            });
            
            //In the following code, we subscribe to the buttons click event, and call the jQuery Grid’s updaterow,
            // deleterow and addrow methods in the event handlers.
                        
            $("#addrowbutton").jqxButton({ theme: theme });
            $("#deleterowbutton").jqxButton({ theme: theme });
            $("#updaterowbutton").jqxButton({ theme: theme });
            $("#refresh").jqxButton({ theme: theme });            
              
            // events        
            $("#refresh").click(function () {
             	 location.reload();
            });
            
            // update row.
            $("#updaterowbutton").bind('click', function () {
                var datarow = generaterow();
                var selectedrowindex = $("#jqxgrid").jqxGrid('getselectedrowindex');
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                if (selectedrowindex >= 0 && selectedrowindex < rowscount) {
                    var id = $("#jqxgrid").jqxGrid('getrowid', selectedrowindex);
                    $("#jqxgrid").jqxGrid('updaterow', id, datarow);
                }
                location.reload();
            });
            
            // create new row.
            $("#addrowbutton").bind('click', function () {
                var rowscount = $("#jqxgrid").jqxGrid('getdatainformation').rowscount;
                var datarow = generaterow(rowscount + 1);
                $("#jqxgrid").jqxGrid('addrow', null, datarow);
            });
                
        	// delete row.
            $("#deleterowbutton").bind('click', function () {
            	//alert("row will be destroy2!");            	
            	location.href = "dataMaJ.php?delete=true&Clef=11";	
            });
                        
            //When cell is selected than informations are displayed
        	$("#jqxgrid").on('cellselect', function (event) {
                var column = $("#jqxgrid").jqxGrid('getcolumn', event.args.datafield);
                var value = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, column.datafield);
                var displayValue = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, column.displayfield);

                $("#eventLog").html("<div>Selected Cell<br/>Row: " + event.args.rowindex + ", Column: " + column.text + ", Value: " + value + ", Label: " + displayValue + "</div>");
        	});

			//After edit celle, informations are displayed
        	$("#jqxgrid").on('cellendedit', function (event) {
                var column = $("#jqxgrid").jqxGrid('getcolumn', event.args.datafield);
                if (column.displayfield != column.datafield) {
                    $("#eventLog").html("<div>Cell Edited:<br/>Index: " + event.args.rowindex + ", Column: " + column.text + "<br/>Value: " + event.args.value.value + ", Label: " + event.args.value.label
                        + "<br/>Old Value: " + event.args.oldvalue.value + ", Old Label: " + event.args.oldvalue.label + "</div>"
                        );
                }
                else {
                    $("#eventLog").html("<div>Cell Edited:<br/>Row: " + event.args.rowindex + ", Column: " + column.text + "<br/>Value: " + event.args.value
                        + "<br/>Old Value: " + event.args.oldvalue + "</div>"
                        );
                }
        	});        
    	});
    </script>
</head>
<body class='default'>
    <div id='jqxWidget' style="font-size: 13px; font-family: Verdana; float: left;">
        <div style="float: left;" id="jqxgrid">
        </div>
        <div id="jqxwindow">
            <div>
                Find Record</div>
            <div style="overflow: hidden;">
                <div>
                    Find what:</div>
                <div style='margin-top:5px;'>
                    <input id='inputField' type="text" class="jqx-input" style="width: 200px; height: 23px;" />
                </div>
                <div style="margin-top: 7px; clear: both;">
                    Look in:</div>
                <div style='margin-top:5px;'>
                    <div id='dropdownlist'>
                    </div>
                </div>
                <div>
                    <input type="button" style='margin-top: 15px; margin-left: 50px; float: left;' value="Find" id="findButton" />
                    <input type="button" style='margin-left: 5px; margin-top: 15px; float: left;' value="Clear" id="clearButton" />
                </div>
            </div>
        </div>
        <div style="font-size: 13px; margin-top: 20px; font-family: Verdana, Geneva, DejaVu Sans, sans-serif;" id="eventLog"></div>
        <div style="margin-left: 30px; float: left;">
            <div>
                <input id="addrowbutton" type="button" value="Add New Row" />
            </div>
            <div style="margin-top: 10px;">
                <input id="deleterowbutton" type="button" value="Delete Selected Row" />
            </div>
            <div style="margin-top: 10px;">
                <input id="updaterowbutton" type="button" value="Update Selected Row" />
            </div>
            <div style="margin-top: 10px;">
                <input id="refresh" type="button" value="Refresh Data" />
            </div>
        </div>                
        <div style="font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
       </div>
    </div>
    </div>
</body>
</html>