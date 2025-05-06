import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SettingsRoutingModule } from './settings-routing.module';
import { FormComponent } from './components/form/form.component';
import { SettingPageComponent } from './components/settings-page/setting-page.component';
import {SharedModule} from "../../shared/shared.module";
import {ReactiveFormsModule} from '@angular/forms';
import { BillingComponent } from './components/billing/billing.component';
import { BankDetailsComponent } from './components/bank-details/bank-details.component';
import { CardDetailsComponent } from './components/card-details/card-details.component';
import { WithdrawalsComponent } from './components/withdrawals/withdrawals.component';
import { ShopDetailsComponent } from './components/shop-details/shop-details.component';
import { TransactionsComponent } from './components/transactions/transactions.component';
import { ReviewsComponent } from './components/reviews/reviews.component';
import { DatePassedDirective } from '../../shared/directives/date-passed.directive';


@NgModule({
  declarations: [
    FormComponent,
    SettingPageComponent,
    BillingComponent,
    BankDetailsComponent,
    CardDetailsComponent,
    WithdrawalsComponent,
    ShopDetailsComponent,
    TransactionsComponent,
    ReviewsComponent,
  ],
    imports: [
        CommonModule,
        SettingsRoutingModule,
        SharedModule,
        ReactiveFormsModule,
   ]
})
export class SettingsModule { }
