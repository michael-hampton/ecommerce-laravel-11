import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ShippingRoutingModule } from './shipping-routing.module';
import { ListComponent } from './components/list/list.component';
import { FormComponent } from './components/form/form.component';
import {ReactiveFormsModule} from "@angular/forms";
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import { CourierFormComponent } from './components/courier-form/courier-form.component';
import { CourierListComponent } from './components/courier-list/courier-list.component';
import { DeliveryPageComponent } from './delivery-page.component';


@NgModule({
  declarations: [
    ListComponent,
    FormComponent,
    CourierFormComponent,
    CourierListComponent,
    DeliveryPageComponent
  ],
  imports: [
    CommonModule,
    ShippingRoutingModule,
    ReactiveFormsModule,
    SharedModule,
    ModalComponent,
  ]
})
export class ShippingModule { }
