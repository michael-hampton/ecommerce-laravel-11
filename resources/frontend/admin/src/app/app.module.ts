import {APP_INITIALIZER, NgModule} from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import {TopbarComponent} from "./core/components/topbar/topbar.component";
import {SidemenuComponent} from './core/components/sidemenu/sidemenu.component';
import {CoreModule} from './core/core.module';
import {HTTP_INTERCEPTORS, provideHttpClient} from '@angular/common/http';
import {ToastComponent} from './shared/components/toast/toast.component';
import {SharedModule} from './shared/shared.module';
import {Toast} from './services/toast/toast.service';
import {AuthState} from './core/services/auth.state';
import {AppInterceptor} from './core/interceptors/http.interceptor';

const CoreProviders = [
  {
    provide: APP_INITIALIZER,
    // dummy factory
    useFactory: () => () => {},
    multi: true,
    // injected depdencies, this will be constructed immidiately
    deps: [AuthState],
  },
  // you might want to add a configuration service
  // add interceptors
  {
    provide: HTTP_INTERCEPTORS,
    multi: true,
    useClass: AppInterceptor,
  },
];

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
  providers: [provideHttpClient(), Toast, ...CoreProviders],
  bootstrap: [AppComponent]
})
export class AppModule { }
