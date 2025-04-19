import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {AttributeValueListComponent} from './components/attribute-value-list/attribute-value-list.component';

const routes: Routes = [
  {path: '', component:AttributeValueListComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class AttributeValuesRoutingModule { }
