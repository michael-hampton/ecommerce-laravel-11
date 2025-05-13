import {Component, inject} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import { BalancePageStore } from '../../balance-page.store';

@Component({
  selector: 'app-transactions',
  standalone: false,
  templateUrl: './transactions.component.html',
  styleUrl: './transactions.component.scss',
  providers: [BalancePageStore]
})
export class TransactionsComponent {

  private _store = inject(BalancePageStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)

  ngOnInit() {

    this._store.getTransactions()
  }

  withdrawFromTransaction(amount: number, transactionId: number) {
    this._store.saveWithdrawal({amount: amount, transactionId: transactionId}).subscribe(result => {
      this._store.getBalance()
    });
  }
}
