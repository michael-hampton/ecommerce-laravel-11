import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProductsRoutingModule } from './products-routing.module';
import { ProductFormComponent } from '../../shared/components/product-form/product-form.component';
import { ProductListComponent } from './components/product-list/product-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import {ReactiveFormsModule} from '@angular/forms';
import { BumpProductComponent } from './components/bump-product/bump-product.component';


@NgModule({
  declarations: [
    ProductListComponent,
    BumpProductComponent
  ],
  imports: [
    CommonModule,
    ProductsRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule,
  ]
})
export class ProductsModule { }
