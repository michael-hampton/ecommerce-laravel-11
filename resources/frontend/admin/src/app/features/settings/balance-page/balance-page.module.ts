import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { BalancePageRoutingModule } from './balance-page-routing.module';
import { BalanceComponent } from './components/balance/balance.component';
import { TransactionsComponent } from './components/transactions/transactions.component';
import { WithdrawalsComponent } from './components/withdrawals/withdrawals.component';
import { BalancePageComponent } from './balance-page.component';
import { ReactiveFormsModule } from '@angular/forms';
import { SharedModule } from "../../../shared/shared.module";


@NgModule({
  declarations: [BalancePageComponent, BalanceComponent, TransactionsComponent, WithdrawalsComponent],
  imports: [
    CommonModule,
    BalancePageRoutingModule,
    ReactiveFormsModule,
    SharedModule
]
})
export class BalancePageModule { }
