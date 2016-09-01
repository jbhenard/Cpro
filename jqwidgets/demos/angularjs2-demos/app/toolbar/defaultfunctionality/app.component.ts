/// <reference path="../../../../../jqwidgets-ts/jqwidgets.d.ts" />
import {Component, ViewChild, AfterViewChecked, ViewEncapsulation} from '@angular/core';
import {jqxToolBarComponent} from '../../../../../jqwidgets-ts/angular_jqxtoolbar';
import {jqxButtonComponent} from '../../../../../jqwidgets-ts/angular_jqxbutton';
import {jqxDropDownListComponent} from '../../../../../jqwidgets-ts/angular_jqxdropdownlist';
import {jqxComboBoxComponent} from '../../../../../jqwidgets-ts/angular_jqxcombobox';
import {jqxInputComponent} from '../../../../../jqwidgets-ts/angular_jqxinput';

@Component({
    selector: 'my-app',
    template: `<angularToolbar></angularToolbar>`,
    styles: [`
        .buttonIcon
        {
            margin: -5px 0 0 -3px;
            width: 16px;
            height: 17px;
        }
    `],
    directives: [jqxToolBarComponent, jqxButtonComponent, jqxDropDownListComponent, jqxComboBoxComponent, jqxInputComponent],
    encapsulation: ViewEncapsulation.None
})
    
export class AppComponent implements AfterViewChecked {
    @ViewChild(jqxToolBarComponent) toolBar: jqxToolBarComponent;
    //@ViewChild(jqxButtonComponent) toggleButton: jqxButtonComponent;
    //@ViewChild(jqxDropDownListComponent) dropDownList: jqxDropDownListComponent;
    //@ViewChild(jqxComboBoxComponent) comboBox: jqxComboBoxComponent;
    //@ViewChild(jqxInputComponent) input: jqxInputComponent;
    //@ViewChild('button') button: jqxButtonComponent;

    toolBarSettings: jqwidgets.ToolBarOptions;
    flag: Boolean = false;
    theme = 'arctic';
    constructor() {
        var self = this;
        this.toolBarSettings = {
            width: 800,
            height: 35,
            tools: 'toggleButton toggleButton toggleButton | toggleButton | dropdownlist combobox | input | custom',
            initTools: function (type, index, tool, menuToolIninitialization) {
                if (type == "toggleButton") {
                    var icon = document.createElement('div');
                    icon.className = 'jqx-editor-toolbar-icon jqx-editor-toolbar-icon-' + this.theme + ' buttonIcon ';
                }
                switch (index) {
                    case 0:
                        icon.className +="jqx-editor-toolbar-icon-bold jqx-editor-toolbar-icon-bold-" + this.theme;
                        icon.setAttribute("title", "Bold");
                        tool[0].appendChild(icon);
                        break;
                    case 1:
                        icon.className += "jqx-editor-toolbar-icon-italic jqx-editor-toolbar-icon-italic-" + this.theme;
                        icon.setAttribute("title", "Italic");
                        tool[0].appendChild(icon);
                        break;
                    case 2:
                        icon.className += "jqx-editor-toolbar-icon-underline jqx-editor-toolbar-icon-underline-" + this.theme;
                        icon.setAttribute("title", "Underline");
                        tool[0].appendChild(icon);
                        break;
                    case 3:
                        tool[0].innerText = 'Enabled';
                        break;

                    case 7:
                        var button = $("<div>" + "<img src='../../images/administrator.png' title='Custom tool' />" + "</div>");
                        tool.append(button);
                        //button.jqxButton({ height: 15 });
                        break;
                }
            }
        };
        
    }

   

    public ngAfterViewChecked(): void {
        var classes = 'jqx-editor-toolbar-icon jqx-editor-toolbar-icon-' + this.theme + ' buttonIcon ';
        if (this.flag === false) {
            var wrapper = (document.getElementsByTagName('angularButton'))[0];
            this.Initialize();

        }
        this.flag = true;
    }

    addIcons(classes: string ,type: string, buttonIndex: number) {
        var icon = (<HTMLElement>document.createElement('div'));
        icon.className = classes;
        icon.setAttribute("title", type);
        (<HTMLElement>document.getElementsByClassName('jqx-button')[buttonIndex]).appendChild(icon);
    }

    Initialize(): void {
        var self = this;
        self.toolBar.createWidget(self.toolBarSettings);        
    }
}
