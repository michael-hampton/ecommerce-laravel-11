import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FieldValidationFlagDirective} from './directives/field-validation-flag.directive';
import {FormSubmitDirective} from "./directives/form-submit.directive";
import {ControlErrorComponent} from './components/control-error/control-error.component';
import {DataTableComponent} from './components/table/data-table/data-table.component';
import {DataTableHeaderComponent} from './components/table/data-table-header/data-table-header.component';
import {RowComponent} from './components/table/row/row.component';
import {ColumnComponent} from './components/table/column/column.component';
import {Hide} from './components/table/utils/hide';
import {FormsModule, ReactiveFormsModule} from '@angular/forms';
import {PixelConverter} from './components/table/utils/px';
import { DataTablePaginationComponent } from './components/table/data-table-pagination/data-table-pagination.component';
import { ToastComponent } from './components/toast/toast.component';

@NgModule({
  declarations: [FieldValidationFlagDirective, FormSubmitDirective, DataTableComponent, DataTableHeaderComponent, RowComponent, ColumnComponent, DataTablePaginationComponent, ToastComponent],
  imports: [
    CommonModule,
    ControlErrorComponent,
    Hide,
    FormsModule,
    PixelConverter,
    ReactiveFormsModule
  ],
  exports: [
    FormSubmitDirective,
    FieldValidationFlagDirective,
    DataTableComponent,
    ColumnComponent,
    ToastComponent
  ]
})
export class SharedModule { }
