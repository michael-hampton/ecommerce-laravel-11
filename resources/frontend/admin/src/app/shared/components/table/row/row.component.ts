import {Component, EventEmitter, forwardRef, Inject, Input, OnDestroy, Output} from '@angular/core';
import {DataTableComponent} from '../data-table/data-table.component';

@Component({
  selector: '[dataTableRow]',
  standalone: false,
  templateUrl: './row.component.html',
  styleUrl: './row.component.scss'
})
export class RowComponent implements OnDestroy {

  @Input() item: any;
  @Input() index: number;

  expanded: boolean;

  // row selection:

  private _selected: boolean;

  @Output() selectedChange = new EventEmitter();
  @Output() expandRowChange = new EventEmitter();

  get selected() {
    return this._selected;
  }

  set selected(selected) {
    this._selected = selected;
    this.selectedChange.emit(selected);
  }

  // other:

  get displayIndex() {
    if (this.dataTable.pagination) {
      return this.dataTable.displayParams.offset + this.index + 1;
    } else {
      return this.index + 1;
    }
  }

  getTooltip() {
    if (this.dataTable.rowTooltip) {
      return this.dataTable.rowTooltip(this.item, this, this.index);
    }
    return '';
  }

  expandRow(event: Event) {
    event.stopPropagation();
    this.expanded = !this.expanded;
    this.expandRowChange.emit();
  }

  constructor(@Inject(forwardRef(() => DataTableComponent)) public dataTable: DataTableComponent) {}

  ngOnDestroy() {
    this.selected = false;
  }

  _this = this; // FIXME is there no template keyword for this in angular 2?
}
