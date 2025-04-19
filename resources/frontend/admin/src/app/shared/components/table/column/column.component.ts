import {Component, ContentChild, Input, OnInit} from '@angular/core';
import {CellCallback, DataTableSortCallback} from '../types';
import {RowComponent} from '../row/row.component';

@Component({
  selector: 'data-table-column',
  standalone: false,
  templateUrl: './column.component.html',
  styleUrl: './column.component.scss'
})
export class ColumnComponent implements OnInit {

  // init:
  @Input() header: string;
  @Input() sortable = false;
  @Input() resizable = false;
  @Input() property: string;
  @Input() styleClass: string;
  @Input() cellColors: CellCallback;
  @Input() customSort: DataTableSortCallback;

  // init and state:
  @Input() width: number | string;
  @Input() visible = true;

  @ContentChild('dataTableCell') cellTemplate: any;
  @ContentChild('dataTableHeader') headerTemplate: any;

  getCellColor(row: RowComponent, index: number) {
    if (this.cellColors !== undefined) {
      return (<CellCallback>this.cellColors)(row.item, row, this, index);
    }

    return '#FFF'
  }

  styleClassObject = {}; // for [ngClass]

  ngOnInit() {
    this._initCellClass();
  }

  private _initCellClass() {
    if (!this.styleClass && this.property) {
      if (/^[a-zA-Z0-9_]+$/.test(this.property)) {
        this.styleClass = 'column-' + this.property;
      } else {
        this.styleClass = 'column-' + this.property.replace(/[^a-zA-Z0-9_]/g, '');
      }
    }

    if (this.styleClass != null) {
      this.styleClassObject = {
        [this.styleClass]: true
      };
    }
  }
}
