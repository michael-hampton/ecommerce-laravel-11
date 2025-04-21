import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { CouponsRoutingModule } from './coupons-routing.module';
import { FormComponent } from './components/form/form.component';
import { CouponListComponent } from './components/coupon-list/coupon-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import {ReactiveFormsModule} from '@angular/forms';
import {InputDirective} from "../../core/input/input.directive";


@NgModule({
  declarations: [
    FormComponent,
    CouponListComponent
  ],
    imports: [
        CommonModule,
        CouponsRoutingModule,
        DataTablesModule,
        SharedModule,
        ModalComponent,
        ReactiveFormsModule,
        InputDirective
    ]
})
export class CouponsModule { }
