import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CouriersRoutingModule } from './couriers-routing.module';
import { ReactiveFormsModule } from '@angular/forms';
import { ModalComponent } from '../../shared/components/modal/modal.component';
import { SharedModule } from '../../shared/shared.module';
import { FormComponent } from './components/form/form.component';
import { ListComponent } from './components/list/list.component';


@NgModule({
  declarations: [FormComponent, ListComponent],
  imports: [
        CommonModule,
        CouriersRoutingModule,
        SharedModule,
        ModalComponent,
        ReactiveFormsModule
  ]
})
export class CouriersModule { }
