import {Component, forwardRef, Inject} from '@angular/core';
import {DataTableComponent} from '../data-table/data-table.component';

@Component({
  selector: 'data-table-header',
  standalone: false,
  templateUrl: './data-table-header.component.html',
  styleUrl: './data-table-header.component.scss'
})
export class DataTableHeaderComponent {

  columnSelectorOpen = false;

  _closeSelector() {
    this.columnSelectorOpen = false;
  }

  constructor(@Inject(forwardRef(() => DataTableComponent)) public dataTable: DataTableComponent) {}
}
