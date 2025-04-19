import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SlidesRoutingModule } from './slides-routing.module';
import { FormComponent } from './components/form/form.component';
import { SlideListComponent } from './components/slide-list/slide-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from '../../shared/components/modal/modal.component';
import {ReactiveFormsModule} from '@angular/forms';


@NgModule({
  declarations: [
    FormComponent,
    SlideListComponent
  ],
  imports: [
    CommonModule,
    SlidesRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class SlidesModule { }
