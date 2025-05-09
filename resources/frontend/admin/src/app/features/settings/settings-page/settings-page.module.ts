import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SettingsPageRoutingModule } from './settings-page-routing.module';
import { NotificationsComponent } from './components/notifications/notifications.component';
import { SettingPageComponent } from './setting-page.component';
import { BillingComponent } from './components/billing/billing.component';
import { AccountDetailsComponent } from './components/account-details/account-details.component';
import { BankDetailsComponent } from './components/bank-details/bank-details.component';
import { CardDetailsComponent } from './components/card-details/card-details.component';
import { SecurityComponent } from './components/security/security.component';
import { ShopDetailsComponent } from './components/shop-details/shop-details.component';
import { FormsModule, ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from '../../../shared/shared.module';
import { CoreModule } from "../../../core/core.module";


@NgModule({
  declarations: [
    SettingPageComponent, 
    NotificationsComponent, 
    BillingComponent, 
    AccountDetailsComponent,
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
    CoreModule
]
})
export class SettingsPageModule { }
