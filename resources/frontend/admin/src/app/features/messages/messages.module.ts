import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { MessagesRoutingModule } from './messages-routing.module';
import { ListComponent } from './components/list/list.component';
import { DetailsComponent } from './components/details/details.component';
import {ReactiveFormsModule} from '@angular/forms';
import { PaginationComponent } from './components/pagination/pagination.component';
import {SharedModule} from "../../shared/shared.module";


@NgModule({
  declarations: [
    ListComponent,
    DetailsComponent,
    PaginationComponent
  ],
    imports: [
        CommonModule,
        MessagesRoutingModule,
        ReactiveFormsModule,
        SharedModule
    ]
})
export class MessagesModule { }
