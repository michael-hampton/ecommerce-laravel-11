import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AttributeListComponent} from '../attributes/components/attribute-list/attribute-list.component';
import {ListComponent} from './components/list/list.component';

const routes: Routes = [
  {path: '', component:ListComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SellersRoutingModule { }
