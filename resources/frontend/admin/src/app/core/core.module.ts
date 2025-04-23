import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {TopbarComponent} from './components/topbar/topbar.component';
import {SidemenuComponent} from "./components/sidemenu/sidemenu.component";
import {RouterLink} from "@angular/router";
import { StatusComponent } from './components/status/status.component';
import {HasRoleDirective} from "../shared/directives/has-role.directive";

@NgModule({
  declarations: [
    TopbarComponent,
    SidemenuComponent,
    StatusComponent
  ],
    imports: [
        CommonModule,
        RouterLink,
        HasRoleDirective
    ],
  exports: [SidemenuComponent, TopbarComponent, StatusComponent]
})
export class CoreModule { }
