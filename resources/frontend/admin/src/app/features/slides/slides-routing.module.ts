import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {SlideListComponent} from './components/slide-list/slide-list.component';

const routes: Routes = [
  {path: '', component:SlideListComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SlidesRoutingModule { }
