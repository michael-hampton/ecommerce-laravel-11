import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {CouponListComponent} from './components/coupon-list/coupon-list.component';

const routes: Routes = [
  {path: '', component:CouponListComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CouponsRoutingModule { }
