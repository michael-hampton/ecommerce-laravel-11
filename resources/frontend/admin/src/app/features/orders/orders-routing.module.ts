import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {OrderListComponent} from './components/order-list/order-list.component';
import {OrderDetailsComponent} from './components/order-details/order-details.component';

const routes: Routes = [
  {path: '', component:OrderListComponent},
  {path: 'details/:id', component:OrderDetailsComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class OrdersRoutingModule { }
