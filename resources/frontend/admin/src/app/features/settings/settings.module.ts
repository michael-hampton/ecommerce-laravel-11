import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SettingsRoutingModule } from './settings-routing.module';
import {SharedModule} from "../../shared/shared.module";
import {ReactiveFormsModule} from '@angular/forms';


@NgModule({
  declarations: [

  ],
    imports: [
        CommonModule,
        SettingsRoutingModule,
        ReactiveFormsModule,
   ]
})
export class SettingsModule { }
