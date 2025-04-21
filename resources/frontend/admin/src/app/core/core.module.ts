import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {TopbarComponent} from './components/topbar/topbar.component';
import {SidemenuComponent} from "./components/sidemenu/sidemenu.component";
import {RouterLink} from "@angular/router";
import { StatusComponent } from './components/status/status.component';

@NgModule({
  declarations: [
    TopbarComponent,
    SidemenuComponent,
    StatusComponent
  ],
  imports: [
    CommonModule,
    RouterLink
  ],
  exports: [SidemenuComponent, TopbarComponent, StatusComponent]
})
export class CoreModule { }
