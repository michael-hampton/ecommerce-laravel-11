import { ModuleWithProviders, NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SettingsPageRoutingModule } from './settings-page-routing.module';
import { NotificationsComponent } from './components/notifications/notifications.component';
import { SettingPageComponent } from './setting-page.component';
import { BillingComponent } from './components/billing/billing.component';
import { BankDetailsComponent } from './components/bank-details/bank-details.component';
import { CardDetailsComponent } from './components/card-details/card-details.component';
import { SecurityComponent } from './components/security/security.component';
import { ShopDetailsComponent } from './components/shop-details/shop-details.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from '../../../shared/shared.module';
import { CoreModule } from "../../../core/core.module";
import { NgxStripeModule, provideNgxStripe } from 'ngx-stripe';
import { environment } from '../../../../environments/environment';


@NgModule({
  declarations: [
    SettingPageComponent, 
    NotificationsComponent, 
    BillingComponent, 
    BankDetailsComponent,
    CardDetailsComponent,
    SecurityComponent,
    ShopDetailsComponent,
  ],
  imports: [
    CommonModule,
    SettingsPageRoutingModule,
    ReactiveFormsModule,
    SharedModule,
    FormsModule,
    CoreModule,
    NgxStripeModule.forRoot()
]
})
export class SettingsPageModule {
   static forRoot(){
    return {
      ngModule: SettingsPageModule,
      providers: [ provideNgxStripe ]
    }
  }
 }
