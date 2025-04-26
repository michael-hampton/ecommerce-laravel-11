import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SellersRoutingModule } from './sellers-routing.module';
import { ListComponent } from './components/list/list.component';
import {SharedModule} from '../../shared/shared.module';


@NgModule({
  declarations: [
    ListComponent
  ],
  imports: [
    CommonModule,
    SellersRoutingModule,
    SharedModule
  ]
})
export class SellersModule { }
