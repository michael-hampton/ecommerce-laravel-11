import {Component, EventEmitter, forwardRef, Inject, Input, Output, SimpleChanges} from '@angular/core';
import {DataTableComponent} from '../data-table/data-table.component';

@Component({
  selector: 'data-table-pagination',
  standalone: false,
  templateUrl: './data-table-pagination.component.html',
  styleUrl: './data-table-pagination.component.scss'
})
export class DataTablePaginationComponent {

  @Output() pageUpdated = new EventEmitter();
  constructor(@Inject(forwardRef(() => DataTableComponent)) public dataTable: DataTableComponent) {
  }

  pageBack() {
    this.dataTable.offset -= Math.min(this.dataTable.limit, this.dataTable.offset);
    this.pageUpdated.emit()
  }

  pageForward() {
    this.dataTable.offset += this.dataTable.limit;
    this.pageUpdated.emit()
  }

  changePage(pageNo: number) {
    this.page = Number(pageNo)
    this.dataTable.page = Number(pageNo)
    this.pageUpdated.emit()
  }

  pageFirst() {
    this.dataTable.offset = 0;
  }

  get startIndex() {
    return (this.page - 1) * this.limit
  }

  get endIndex() {
    return Math.min(this.startIndex + this.limit - 1, this.itemCount - 1);
  }

  pageLast() {
    this.dataTable.offset = (this.maxPage - 1) * this.dataTable.limit;
  }

  get itemCount() {
    return this.dataTable.itemCount
  }

  get pages() {
    let startPage: number, endPage: number;
    if (this.maxPage <= 10) {
      // less than 10 total pages so show all
      startPage = 1;
      endPage = this.maxPage;
    } else {
      // more than 10 total pages so calculate start and end pages
      if (this.page <= 6) {
        startPage = 1;
        endPage = 10;
      } else if (this.page + 4 >= this.maxPage) {
        startPage = this.maxPage - 9;
        endPage = this.maxPage;
      } else {
        startPage = this.page - 5;
        endPage = this.page + 4;
      }
    }
   return Array.from(Array(endPage + 1 - startPage).keys()).map(i => startPage + i);
  }

  get maxPage() {
    return Math.ceil(this.dataTable.itemCount / this.dataTable.limit);
  }

  get limit() {
    return this.dataTable.limit;
  }

  set limit(value) {
    this.dataTable.limit = Number(<any>value); // TODO better way to handle that value of number <input> is string?
  }

  get page() {
    return this.dataTable.page;
  }

  set page(value) {
    this.dataTable.page = Number(<any>value);
  }

  // Track by
  trackByFn(index: any, item: any) {
    return item; // or item.id
  }
}
