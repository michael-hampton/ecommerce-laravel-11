import {
  Component,
  ContentChild,
  ContentChildren,
  EventEmitter,
  Input,
  OnInit,
  Output,
  QueryList, SimpleChanges,
  TemplateRef,
  ViewChildren
} from '@angular/core';
import {
  DataTableParams,
  DataTableSortCallback,
  DataTableTranslations,
  defaultTranslations,
  RowCallback
} from '../types';
import {RowComponent} from '../row/row.component';
import {ColumnComponent} from '../column/column.component';
import {FilterModel} from '../../../../types/filter.model';

@Component({
  selector: 'app-table',
  standalone: false,
  templateUrl: './data-table.component.html',
  styleUrl: './data-table.component.scss'
})
export class DataTableComponent implements DataTableParams, OnInit {
  private _items: any[] = [];

  @Input() get items() {
    return this._items;
  }

  set items(items: any[]) {
    this._items = items;
    this._onReloadFinished();
  }

  @Input() itemCount: number;

   @Input() searchText: string = ''

  // UI components:

  @ContentChildren(ColumnComponent) columns: QueryList<ColumnComponent>;
  @ViewChildren(RowComponent) rows: QueryList<RowComponent>;
  @ContentChild('dataTableExpand') expandTemplate: TemplateRef<any>;

  // One-time optional bindings with default values:

  @Input() headerTitle: string;
  @Input() header = true;
  @Input() pagination = true;
  @Input() indexColumn = true;
  @Input() indexColumnHeader = '';
  @Input() rowColors: RowCallback;
  @Input() rowTooltip: RowCallback;
  @Input() selectColumn = false;
  @Input() multiSelect = true;
  @Input() substituteRows = false;
  @Input() expandableRows = false;
  @Input() translations: DataTableTranslations = defaultTranslations;
  @Input() selectOnRowClick = false;
  @Input() autoReload = false;
  @Input() loading = false;
  @Input() showDownloadButton = false;
  @Output() changePage = new EventEmitter();
  @Output() addButton = new EventEmitter();

  // UI state without input:

  indexColumnVisible: boolean;
  selectColumnVisible: boolean;
  expandColumnVisible: boolean;

  // UI state: visible ge/set for the outside with @Input for one-time initial values

  private _search: string = '';
  private _sortBy: string;
  private _sortAsc = true;
  private _customSort: DataTableSortCallback;

  private _offset = 0;
  private _limit = 10;

  @Input()
  get sortBy() {
    return this._sortBy;
  }

  @Input()
  get search() {
    return this._search;
  }

  set sortBy(value) {
    this._sortBy = value;
    //this._triggerReload();
  }

  set search(value: string) {
    this._search = value;
  }

  @Input()
  get sortAsc() {
    return this._sortAsc;
  }

  @Input()
  set sortDir(value: string) {
    this._sortAsc = value === 'asc';
    //this._triggerReload();
  }

  set sortAsc(value) {
    this._sortAsc = value;
    //this._triggerReload();
  }

  @Input()
  get customSort() {
    return this._customSort;
  }

  set customSort(value) {
    this._customSort = value;
    //this._triggerReload();
  }

  @Input()
  get offset() {
    return this._offset;
  }

  set offset(value) {
    this._offset = value;
    //this._triggerReload();
  }

  @Input()
  get limit() {
    return this._limit;
  }

  set limit(value) {
    this._limit = value;
    //this._triggerReload();
  }

  // calculated property:

  @Input()
  get page() {
    return Math.floor(this.offset / this.limit) + 1;
  }

  set page(value) {
    this.offset = (value - 1) * this.limit;
  }

  get lastPage() {
    return Math.ceil(this.itemCount / this.limit);
  }

  // setting multiple observable properties simultaneously

  sort(sortBy: string, asc: boolean, customSort: DataTableSortCallback) {
    this.sortBy = sortBy;
    this.sortAsc = asc;
    this.customSort = customSort;
  }

  // init


  ngOnInit() {
    this._initDefaultValues();
    this._initDefaultClickEvents();
    this._updateDisplayParams();

    if (this.autoReload && this._scheduledReload == null) {
      this.reloadItems();
    }
  }

  // ngOnChanges(changes: SimpleChanges) {
  //   console.log('changes', changes['page'])
  // }

  private _initDefaultValues() {
    this.indexColumnVisible = this.indexColumn;
    this.selectColumnVisible = this.selectColumn;
    this.expandColumnVisible = this.expandableRows;
  }

  private _initDefaultClickEvents() {
    this.headerClick.subscribe((tableEvent: any) => this.sortColumn(tableEvent.column));
    if (this.selectOnRowClick) {
      this.rowClick.subscribe((tableEvent: any) => tableEvent.row.selected = !tableEvent.row.selected);
    }
  }

  // Reloading:

  _reloading = false;

  get reloading() {
    return this._reloading;
  }

  @Output() reload = new EventEmitter();

  reloadItems() {
    this._reloading = true;
    this._search = ''
    this.reload.emit(this._getRemoteParameters());
  }

  private _onReloadFinished() {
    this._updateDisplayParams();

    this._selectAllCheckbox = false;
    this._reloading = false;
  }

  _displayParams = <DataTableParams>{}; // params of the last finished reload

  get displayParams() {
    return this._displayParams;
  }

  _updateDisplayParams() {
    this._displayParams = {
      sortBy: this.sortBy,
      customSort: this.customSort,
      sortDir: this.sortAsc === true ? 'asc' : 'desc',
      offset: this.offset,
      limit: this.limit
    };
  }

  _scheduledReload: any = null;

  // for avoiding cascading reloads if multiple params are set at once:
  _triggerReload() {
    if (this._scheduledReload) {
      clearTimeout(this._scheduledReload);
    }
    this._scheduledReload = setTimeout(() => {
      this.reloadItems();
    });
  }

  pageChanged() {
    this.changePage.emit({
      page: this.page,
      limit: this.limit,
      sortBy: this.sortBy,
      sortDir: this.sortAsc === true ? 'asc' : 'desc',
      searchText: this.search ?? ''
    } as FilterModel)
  }

  searchChanged(search: {search: string}) {
    this.search = search.search;
    this.pageChanged()
  }

  // Download
  @Output() download = new EventEmitter();

  downloadItems() {
    this.download.emit(this._getRemoteParameters());
  }

  // event handlers:

  @Output() rowClick = new EventEmitter();
  @Output() rowDoubleClick = new EventEmitter();
  @Output() headerClick = new EventEmitter();
  @Output() cellClick = new EventEmitter();
  @Output() rowExpandChange = new EventEmitter();

  rowClicked(row: RowComponent, event: Event) {
    this.rowClick.emit({row, event});
  }

  rowDoubleClicked(row: RowComponent, event: Event) {
    this.rowDoubleClick.emit({row, event});
  }

  headerClicked(column: ColumnComponent, event: MouseEvent) {
    if (!this._resizeInProgress && column.sortable) {
      let ascending = this.sortBy === column.property ? !this.sortAsc : true;
      this.changePage.emit({page: this.page, limit: this.limit, sortBy: column.property, sortDir: ascending === true ? 'asc' : 'desc'})
    } else {
      this._resizeInProgress = false; // this is because I can't prevent click from mousup of the drag end
    }
  }

  private cellClicked(column: ColumnComponent, row: RowComponent, event: MouseEvent) {
    this.cellClick.emit({row, column, event});
  }

  // functions:

  private _getRemoteParameters(): DataTableParams {
    let params = <DataTableParams>{};

    if (this.sortBy) {
      params.sortBy = this.sortBy;
      params.customSort = this.customSort;
      params.sortDir = this.sortAsc === true ? 'asc' : 'desc';
    }
    if (this.pagination) {
      params.offset = this.offset;
      params.limit = this.limit;
    }
    return params;
  }

  private sortColumn(column: ColumnComponent) {
    if (column.sortable) {
      let ascending = this.sortBy === column.property ? !this.sortAsc : true;
      this.sort(column.property, ascending, column.customSort);
    }
  }

  get columnCount() {
    let count = 0;
    count += this.indexColumnVisible ? 1 : 0;
    count += this.selectColumnVisible ? 1 : 0;
    count += this.expandColumnVisible ? 1 : 0;
    this.columns.toArray().forEach(column => {
      count += column.visible ? 1 : 0;
    });
    return count;
  }

  getRowColor(item: any, index: number, row: RowComponent) {
    if (this.rowColors !== undefined) {
      return (<RowCallback>this.rowColors)(item, row, index);
    }

    return '#FFF'
  }

  // selection:

  selectedRow: RowComponent;
  selectedRows: RowComponent[] = [];

  private _selectAllCheckbox = false;

  get selectAllCheckbox() {
    return this._selectAllCheckbox;
  }

  set selectAllCheckbox(value) {
    this._selectAllCheckbox = value;
    this._onSelectAllChanged(value);
  }

  private _onSelectAllChanged(value: boolean) {
    this.rows.toArray().forEach(row => row.selected = value);
  }

  onRowSelectChanged(row: RowComponent) {
    // maintain the selectedRow(s) view
    if (this.multiSelect) {
      let index = this.selectedRows.indexOf(row);
      if (row.selected && index < 0) {
        this.selectedRows.push(row);
      } else if (!row.selected && index >= 0) {
        this.selectedRows.splice(index, 1);
      }
    } else {
      if (row.selected) {
        this.selectedRow = row;
      } else if (this.selectedRow === row) {
        this.selectedRow = row;
      }
    }

    // unselect all other rows:
    if (row.selected && !this.multiSelect) {
      this.rows.toArray().filter(row_ => row_.selected).forEach(row_ => {
        if (row_ !== row) { // avoid endless loop
          row_.selected = false;
        }
      });
    }
  }

  onRowExpandChanged(row: RowComponent) {
    this.rowExpandChange.emit(row);
  }

  // other:

  get substituteItems() {
    return Array.from({length: this.displayParams.limit - this.items.length});
  }

  // column resizing:

  private _resizeInProgress = false;

  protected resizeColumnStart(event: MouseEvent, column: ColumnComponent, columnElement: HTMLElement) {
    this._resizeInProgress = true;

    // drag(event, {
    //   move: (moveEvent: MouseEvent, dx: number) => {
    //     if (this._isResizeInLimit(columnElement, dx)) {
    //       column.width = columnElement.offsetWidth + dx;
    //     }
    //   },
    // });
  }

  resizeLimit = 30;

  private _isResizeInLimit(columnElement: HTMLElement, dx: number) {
    /* This is needed because CSS min-width didn't work on table-layout: fixed.
     Without the limits, resizing can make the next column disappear completely,
     and even increase the table width. The current implementation suffers from the fact,
     that offsetWidth sometimes contains out-of-date values. */
    if ((dx < 0 && (columnElement.offsetWidth + dx) <= this.resizeLimit) || !columnElement.nextElementSibling || // resizing doesn't make sense for the last visible column
      (dx >= 0 && ((<HTMLElement>columnElement.nextElementSibling).offsetWidth + dx) <= this.resizeLimit)) {
      return false;
    }
    return true;
  }
}
