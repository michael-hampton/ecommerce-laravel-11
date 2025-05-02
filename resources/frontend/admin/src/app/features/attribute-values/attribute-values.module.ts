import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { AttributeValuesRoutingModule } from './attribute-values-routing.module';
import { FormComponent } from './components/form/form.component';
import { AttributeValueListComponent } from './components/attribute-value-list/attribute-value-list.component';
import { DataTablesModule } from 'angular-datatables';
import { SharedModule } from '../../shared/shared.module';
import { ModalComponent } from '../../shared/components/modal/modal.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    FormComponent,
    AttributeValueListComponent
  ],
  imports: [
    CommonModule,
    AttributeValuesRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class AttributeValuesModule { }
