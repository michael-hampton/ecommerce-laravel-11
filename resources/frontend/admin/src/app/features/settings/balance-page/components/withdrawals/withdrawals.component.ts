import {Component, inject, TemplateRef, ViewChild, ViewContainerRef} from '@angular/core';
import {FormBuilder, FormGroup} from '@angular/forms';
import { WithdrawalStore } from './withdrawal.store';

@Component({
  selector: 'app-withdrawals',
  standalone: false,
  templateUrl: './withdrawals.component.html',
  styleUrl: './withdrawals.component.scss',
  providers: [WithdrawalStore]
})
export class WithdrawalsComponent {

  private _store = inject(WithdrawalStore)
  vm$ = this._store.vm$
  form: FormGroup;
  @ViewChild('activateBalanceModal', { static: true, read: ViewContainerRef })
  activateBalanceModal!: ViewContainerRef;
  activateBalanceForm: FormGroup
  @ViewChild('activateBalanceModalForm') activateBalanceModalForm: TemplateRef<any>;

  ngOnInit() {

    this._store.getWithdrawals()
  }
}
