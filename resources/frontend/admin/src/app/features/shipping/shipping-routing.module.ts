import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {SettingPageComponent} from '../settings/settings-page/setting-page.component';
import {ListComponent} from './components/list/list.component';
import {FormComponent} from './components/form/form.component';
import { DeliveryPageComponent } from './delivery-page.component';

const routes: Routes = [
  {path: '', component:DeliveryPageComponent},
  {path: 'form', component:FormComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class ShippingRoutingModule { }
