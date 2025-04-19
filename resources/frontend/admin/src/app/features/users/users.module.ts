import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { UsersRoutingModule } from './users-routing.module';
import { FormComponent } from './components/form/form.component';
import { UserListComponent } from './components/user-list/user-list.component';
import {DataTablesModule} from 'angular-datatables';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from "../../shared/components/modal/modal.component";
import {ReactiveFormsModule} from "@angular/forms";


@NgModule({
  declarations: [
    FormComponent,
    UserListComponent,
  ],
  imports: [
    CommonModule,
    UsersRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class UsersModule { }
