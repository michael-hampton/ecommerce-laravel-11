import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FieldValidationFlagDirective } from './directives/field-validation-flag.directive';
import { FormSubmitDirective } from "./directives/form-submit.directive";
import { ControlErrorComponent } from './components/control-error/control-error.component';
import { DataTableComponent } from './components/table/data-table/data-table.component';
import { DataTableHeaderComponent } from './components/table/data-table-header/data-table-header.component';
import { RowComponent } from './components/table/row/row.component';
import { ColumnComponent } from './components/table/column/column.component';
import { Hide } from './components/table/utils/hide';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { PixelConverter } from './components/table/utils/px';
import { DataTablePaginationComponent } from './components/table/data-table-pagination/data-table-pagination.component';
import { ToastComponent } from './components/toast/toast.component';
import { LoaderComponent } from './components/loader/loader.component';
import { CategorySelectorComponent } from './components/category-selector/category-selector.component';
import { ControlValueAccessorDirective } from './directives/control-value-accessor.directive';
import { DatePassedDirective } from './directives/date-passed.directive';
import { ProductFormComponent } from './components/product-form/product-form.component';
import { ModalComponent } from './components/modal/modal.component';
import { UiTabsComponent } from './components/ui-tabs/ui-tabs.component';
import { UiTabItemComponent } from './components/ui-tab-item/ui-tab-item.component';
import { UiSideMenuComponent } from './components/ui-side-menu/ui-side-menu.component';

@NgModule({
  declarations: [FieldValidationFlagDirective, FormSubmitDirective, DataTableComponent, DataTableHeaderComponent, RowComponent, ColumnComponent, DataTablePaginationComponent, ToastComponent, LoaderComponent, CategorySelectorComponent, ControlValueAccessorDirective, DatePassedDirective, ProductFormComponent, UiTabsComponent, UiTabItemComponent, UiSideMenuComponent],
  imports: [
    CommonModule,
    ControlErrorComponent,
    Hide,
    FormsModule,
    PixelConverter,
    ReactiveFormsModule,
    ModalComponent
  ],
  exports: [
    FormSubmitDirective,
    FieldValidationFlagDirective,
    DataTableComponent,
    ColumnComponent,
    ToastComponent,
    LoaderComponent,
    CategorySelectorComponent,
    DatePassedDirective,
    ProductFormComponent,
    UiTabsComponent,
    UiTabItemComponent, 
    UiSideMenuComponent
  ]
})
export class SharedModule { }
