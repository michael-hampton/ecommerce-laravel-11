import {APP_INITIALIZER, DEFAULT_CURRENCY_CODE, NgModule} from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { NgbModule } from '@ng-bootstrap/ng-bootstrap';
import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import {CoreModule} from './core/core.module';
import {HTTP_INTERCEPTORS, HttpClientModule, provideHttpClient, withInterceptorsFromDi} from '@angular/common/http';
import {SharedModule} from './shared/shared.module';
import {Toast} from './services/toast/toast.service';
import {AuthState} from './core/auth/auth.state';
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
  providers: [provideHttpClient(withInterceptorsFromDi()), Toast, ...CoreProviders,  {
    provide: HTTP_INTERCEPTORS, useClass: AppInterceptor, multi: true
  },  {provide: DEFAULT_CURRENCY_CODE, useValue: 'GBP'}],
  bootstrap: [AppComponent]
})
export class AppModule { }
