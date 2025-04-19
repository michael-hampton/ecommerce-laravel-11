import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import {SettingPageComponent} from './components/settings-page/setting-page.component';

const routes: Routes = [
  {path: '', component:SettingPageComponent},
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SettingsRoutingModule { }
