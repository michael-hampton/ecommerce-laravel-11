import {Component, inject, TemplateRef, ViewChild, ViewContainerRef} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AccountDetails} from '../../../../../types/seller/account-details';
import {Billing} from '../../../../../types/seller/billing';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../../services/modal.service';
import { forkJoin, map } from 'rxjs';
import { AuthService } from '../../../../../core/auth/auth.service';
import { BalancePageStore } from '../../balance-page.store';
import { SellerApi } from '../../../../../apis/seller.api';
import { LookupStore } from '../../../../../store/lookup.store';

@Component({
  selector: 'app-balance',
  standalone: false,
  templateUrl: './balance.component.html',
  styleUrl: './balance.component.scss',
  providers: [BalancePageStore]
})
export class BalanceComponent {

  private _store = inject(BalancePageStore)
  private _api = inject(SellerApi)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;
  private _modalService = inject(ModalService)
  @ViewChild('activateBalanceModal', { static: true, read: ViewContainerRef })
  activateBalanceModal!: ViewContainerRef;
  activateBalanceForm: FormGroup
  @ViewChild('activateBalanceModalForm') activateBalanceModalForm: TemplateRef<any>;

  private _authService = inject(AuthService)
  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$

  ngOnInit() {
    this._store.getData(Number(this._authService.GetUser().payload.id)).subscribe()
    this.initWithdrawBalanceForm()
    this._lookupStore.getCountries()

    this._store.getBalance()
  }

  initWithdrawBalanceForm() {
    this.form = this.fb.group({
      amount: new FormControl(0, [Validators.required]),
    })
  }

  initActivateBalanceForm() {
    this.activateBalanceForm = this.fb.group({
      date_of_birth: new FormControl(''),
      name: new FormControl('', Validators.required),
      email: new FormControl('', Validators.required),
      address1: new FormControl('', Validators.required),
      address2: new FormControl(''),
      city: new FormControl('', Validators.required),
      state: new FormControl('', Validators.required),
      zip: new FormControl('', Validators.required),
      country_id: new FormControl('', Validators.required),
      phone: new FormControl('')
    })
  }

  withdraw() {
    if (this.form.valid) {
      this._store.saveWithdrawal({amount: this.form.value.amount}).subscribe(result => {
        this._store.getBalance()
      });
    }
    console.log(this.form.value)
  }

  activateBalance() {
    this.initActivateBalanceForm();

    forkJoin([this._api.getBilling(), this._api.getSellerBankAccountDetails()])
    .pipe(
      map(([billingData, bankAccountData]) => {
        return {
          billingData: billingData as Billing,
          bankAccountData: bankAccountData as AccountDetails,
        };
      })
    )
    .subscribe(results => {
      this.activateBalanceForm.patchValue({
        address1: results.billingData.address1 || '',
        address2: results.billingData.address2 || '',
        city: results.billingData.city || '',
        state: results.billingData.state || '',
        zip: results.billingData.zip || '',
        country_id: results.billingData.country_id,
        name: results.bankAccountData.account_name || ''
      })
    });

    this._modalService
          .openConfirmationModal({
            modalTitle: 'Activate Balance',
            template: this.activateBalanceModalForm,
            showFooter: true,
            saveButtonLabel: 'Activate balance',
            size: 'modal-lg'
          })
          .subscribe((v) => {
            this._store.activateBalance(this.activateBalanceForm.value).subscribe()
          });
  }
}
