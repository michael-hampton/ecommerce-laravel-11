import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';

@Component({
  selector: 'app-transactions',
  standalone: false,
  templateUrl: './transactions.component.html',
  styleUrl: './transactions.component.scss',
  providers: [ProfileStore]
})
export class TransactionsComponent {

  private _store = inject(ProfileStore)
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
