import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SettingsRoutingModule } from './settings-routing.module';
import { FormComponent } from './components/form/form.component';
import { SettingPageComponent } from './components/settings-page/setting-page.component';
import {SharedModule} from "../../shared/shared.module";
import {ReactiveFormsModule} from '@angular/forms';


@NgModule({
  declarations: [
    FormComponent,
    SettingPageComponent
  ],
    imports: [
        CommonModule,
        SettingsRoutingModule,
        SharedModule,
        ReactiveFormsModule
    ]
})
export class SettingsModule { }
