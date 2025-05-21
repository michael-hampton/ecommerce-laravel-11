import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { OrdersRoutingModule } from './orders-routing.module';
import { FormComponent } from './components/form/form.component';
import { OrderListComponent } from './components/order-list/order-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import {ReactiveFormsModule} from '@angular/forms';
import { OrderDetailsComponent } from './components/order-details/order-details.component';
import { RefundModalComponent } from './components/refund-modal/refund-modal.component';


@NgModule({
  declarations: [
    FormComponent,
    OrderListComponent,
    OrderDetailsComponent,
    RefundModalComponent
  ],
  imports: [
    CommonModule,
    OrdersRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class OrdersModule { }
