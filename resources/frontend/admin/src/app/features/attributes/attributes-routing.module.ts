import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AttributeListComponent} from './components/attribute-list/attribute-list.component';

const routes: Routes = [
  {path: '', component:AttributeListComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AttributesRoutingModule { }
