import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BrandsRoutingModule } from './brands-routing.module';
import { FormComponent } from './components/form/form.component';
import { BrandListComponent } from './components/brand-list/brand-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import {ReactiveFormsModule} from '@angular/forms';


@NgModule({
  declarations: [
    FormComponent,
    BrandListComponent
  ],
  imports: [
    CommonModule,
    BrandsRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class BrandsModule { }
