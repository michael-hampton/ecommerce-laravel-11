import {RowComponent} from './row/row.component';
import {ColumnComponent} from './column/column.component';

export type RowCallback = (item: any, row: RowComponent, index: number) => string;

export type CellCallback = (item: any, row: RowComponent, column: ColumnComponent, index: number) => string;

// export type HeaderCallback = (column: DataTableColumn) => string;

export type DataTableSortCallback = (a: any, b: any) => number;

export interface DataTableTranslations {
  indexColumn: string;
  selectColumn: string;
  expandColumn: string;
  paginationLimit: string;
  paginationRange: string;
}

export var defaultTranslations = <DataTableTranslations>{
  indexColumn: 'index',
  selectColumn: 'select',
  expandColumn: 'expand',
  paginationLimit: 'Limit',
  paginationRange: 'Results'
};


export interface DataTableParams {
  offset?: number;
  limit?: number;
  sortBy?: string;
  customSort?: DataTableSortCallback;
  sortDir?: string;
}
