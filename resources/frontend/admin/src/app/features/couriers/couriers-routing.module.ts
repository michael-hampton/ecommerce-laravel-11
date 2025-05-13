import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {ListComponent} from './components/list/list.component';
import {FormComponent} from './components/form/form.component';

const routes: Routes = [
  {path: '', component:ListComponent},
  {path: 'form', component:FormComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class CouriersRoutingModule { }
