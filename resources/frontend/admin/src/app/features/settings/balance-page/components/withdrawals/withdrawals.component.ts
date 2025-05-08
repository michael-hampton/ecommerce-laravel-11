import {Component, inject, TemplateRef, ViewChild, ViewContainerRef} from '@angular/core';
import {ProfileStore} from '../../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../../types/seller/seller';
import {AccountDetails} from '../../../../../types/seller/account-details';
import {Billing} from '../../../../../types/seller/billing';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../../services/modal.service';
import { forkJoin, map, withLatestFrom } from 'rxjs';

@Component({
  selector: 'app-withdrawals',
  standalone: false,
  templateUrl: './withdrawals.component.html',
  styleUrl: './withdrawals.component.scss',
  providers: [ProfileStore]
})
export class WithdrawalsComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;
  private _modalService = inject(ModalService)
  @ViewChild('activateBalanceModal', { static: true, read: ViewContainerRef })
  activateBalanceModal!: ViewContainerRef;
  activateBalanceForm: FormGroup
  @ViewChild('activateBalanceModalForm') activateBalanceModalForm: TemplateRef<any>;

  ngOnInit() {
    // this.initWithdrawBalanceForm()

    this._store.getWithdrawals()
    // this._store.getBalance()
  }

  // initWithdrawBalanceForm() {
  //   this.form = this.fb.group({
  //     amount: new FormControl(0, [Validators.required]),
  //   })
  // }

  // withdraw() {
  //   if (this.form.valid) {
  //     this._store.saveWithdrawal({amount: this.form.value.amount}).subscribe(result => {
  //       this._store.getBalance()
  //     });
  //   }
  //   console.log(this.form.value)
  // }
}
