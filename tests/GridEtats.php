<!DOCTYPE html>
<html lang="en">
<head>
<base href="http://cpro.jbh/" />
<title id='Description'>In order to enter in edit mode, select a grid row, then "Click" or press the "F2" key. To cancel the editing, press the "Esc" key. To save
    the changes press the "Enter" key or select another Grid row.</title>
    
    <meta name="description" content="JavaScript Grid with Tooltips for each grid cell" /> 	
    
    <link rel="stylesheet" href="jqwidgets/jqwidgets/styles/jqx.base.css" type="text/css" />
    <link rel="stylesheet" href="jqwidgets/jqwidgets/styles/jqx.classic.css" type="text/css" />

    <script type="text/javascript" src="jqwidgets/scripts/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxdata.js"></script> 
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxbuttons.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxscrollbar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxmenu.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.edit.js"></script>  
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.selection.js"></script> 
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxlistbox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxdropdownlist.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcheckbox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcalendar.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxnumberinput.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxdatetimeinput.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/globalization/globalize.js"></script>
    <script type="text/javascript" src="jqwidgets/scripts/demos.js"></script>
    <script type="text/javascript" src="jqwidgets/demos/jqxgrid/generatedata.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxexpander.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxdragdrop.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxpanel.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcombobox.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.pager.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxwindow.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.filter.js"></script>
    <script type="text/javascript" src="tests/generatedata.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxgrid.sort.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxtooltip.js"></script>
    <script type="text/javascript" src="jqwidgets/jqwidgets/jqxcheckbox.js"></script>
    
    <script type="text/javascript">
    	$(document).ready(function () {
    		// prepare the data     
    		var url = 'dataMaJ.php';
    		var varG='';       
            var data = {};
            var theme = 'classic';
            
        var generaterow = function (id) {
            var row = {};            
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
                url: url,                
                addrow: function (rowid, rowdata, position, commit) {
                    // synchronize with the server - send insert command
                    var data = "insert=true&" + $.param(rowdata);
                    $.ajax({
                        dataType: 'json',
                        url: url,
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
                deleterow: function (rowid, commit) {									
			    // synchronize with the server - send delete command						
			        var data = "delete=true&" + $.param({Clef: rowid});						
					$.ajax({				
			            dataType: 'json',						
			            url: url,						
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
	                        url: url,
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
                	},
                sortcolumn: 'ShipName',
                sortdirection: 'asc'
            	};            
               	var dataAdapter = new $.jqx.dataAdapter(source);
            	return dataAdapter;
        }
                     
        var tooltiprenderer = function (element) {
                $(element).jqxTooltip({position: 'mouse', content: $(element).text() });
        }

            // initialize jqxGrid
        $("#jqxgrid").jqxGrid({
                width: 750,                
                editable: true,                
                selectionmode: 'singlecell',
                editmode: 'selectedrow',
                height: 350,
             	source: getAdapter(), 
             	showfilterrow: true,
                filterable: true,
                showstatusbar: true,
                renderstatusbar: function (statusbar) {
                    // appends buttons to the status bar.
                    var container = $("<div style='overflow: hidden; position: relative; margin: 5px;'></div>");
                    var addButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='jqwidgets/images/add.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Add</span></div>");
                    var deleteButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='jqwidgets/images/close.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Delete</span></div>");
                    var reloadButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='jqwidgets/images/refresh.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Reload</span></div>");
                    var searchButton = $("<div style='float: left; margin-left: 5px;'><img style='position: relative; margin-top: 2px;' src='jqwidgets/images/search.png'/><span style='margin-left: 4px; position: relative; top: -3px;'>Find</span></div>");
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
                		location.href = "dataMaJ.php?insert=true";
                    });
                    
					// delete selected row.
                    deleteButton.click(function (event) {
                    	alert("row will be destroy!" + varG);
                        location.href = "dataMaJ.php?delete=true&Clef=" + varG;
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
                sortable: true,
                altrows: true,           
                columns: [
                      { text: 'Clef', columntype: 'textbox', filtertype: 'textbox', datafield: 'Clef', width: 100, editable: false, rendered: tooltiprenderer },
                      { text: 'Champ', columntype: 'textbox', filtertype: 'textbox', datafield: 'Champ', width: 150, rendered: tooltiprenderer },
                      { text: 'Valeur', columntype: 'textbox', filtertype: 'textbox', datafield: 'Valeur', width: 300, rendered: tooltiprenderer },
                      { text: 'Mail', columntype: 'textbox', filtertype: 'textbox', datafield: 'Mail', width: 100, rendered: tooltiprenderer },
                      { text: 'Séquence', columntype: 'textbox', filtertype: 'textbox', datafield: 'Sequence', width: 100, rendered: tooltiprenderer }                      
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
            
            //Events        
            //When cell is selected than informations are displayed
        	$("#jqxgrid").on('cellselect', function (event) {
                var column = $("#jqxgrid").jqxGrid('getcolumn', event.args.datafield);
                var value = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, column.datafield);
                var displayValue = $("#jqxgrid").jqxGrid('getcellvalue', event.args.rowindex, column.displayfield);
				varG = displayValue;
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
        <div style="font-size: 12px; font-family: Verdana, Geneva, 'DejaVu Sans', sans-serif; margin-top: 30px;">
            <div id="cellbegineditevent"></div>
            <div style="margin-top: 10px;" id="cellendeditevent"></div>
       </div>
    </div>
    </div>
</body>
</html>