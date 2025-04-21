import {Component, EventEmitter, forwardRef, Inject, Output} from '@angular/core';
import {DataTableComponent} from '../data-table/data-table.component';

@Component({
  selector: 'data-table-header',
  standalone: false,
  templateUrl: './data-table-header.component.html',
  styleUrl: './data-table-header.component.scss'
})
export class DataTableHeaderComponent {

  columnSelectorOpen = false;
  @Output() searchUpdated = new EventEmitter();

  _closeSelector() {
    this.columnSelectorOpen = false;
  }

  constructor(@Inject(forwardRef(() => DataTableComponent)) public dataTable: DataTableComponent) {}

  search(event: KeyboardEvent) {
    const inputValue = (event.target as HTMLInputElement).value;
    this.searchUpdated.emit({search: inputValue})
  }

  addButtonClicked(event: Event) {
    this.dataTable.addButton.emit(event)
  }
}
