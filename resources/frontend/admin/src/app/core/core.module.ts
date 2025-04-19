import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {TopbarComponent} from './components/topbar/topbar.component';
import {SidemenuComponent} from "./components/sidemenu/sidemenu.component";
import {RouterLink} from "@angular/router";

@NgModule({
  declarations: [
    TopbarComponent,
    SidemenuComponent
  ],
  imports: [
    CommonModule,
    RouterLink
  ],
  exports: [SidemenuComponent, TopbarComponent]
})
export class CoreModule { }
