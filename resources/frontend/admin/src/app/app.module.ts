import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import {TopbarComponent} from "./core/components/topbar/topbar.component";
import {SidemenuComponent} from './core/components/sidemenu/sidemenu.component';
import {CoreModule} from './core/core.module';
import {provideHttpClient} from '@angular/common/http';
import {ToastComponent} from './shared/components/toast/toast.component';
import {SharedModule} from './shared/shared.module';
import {Toast} from './services/toast/toast.service';

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    CoreModule,
    NgbModule,
    SharedModule,
  ],
  providers: [provideHttpClient(), Toast],
  bootstrap: [AppComponent]
})
export class AppModule { }
