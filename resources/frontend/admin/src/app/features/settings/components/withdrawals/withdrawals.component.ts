import {Component, inject, TemplateRef, ViewChild, ViewContainerRef} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';
import {AccountDetails} from '../../../../types/seller/account-details';
import {Billing} from '../../../../types/seller/billing';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../services/modal.service';
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
    this.initWithdrawBalanceForm()

    this._store.getWithdrawals()
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
      account_holders_name: new FormControl(''),
      address1: new FormControl(''),
      address2: new FormControl(''),
      city: new FormControl(''),
      state: new FormControl(''),
      zip: new FormControl(''),
      country_id: new FormControl(''),
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

    forkJoin([this._store.getBilling(), this._store.getSellerBankAccountDetails()])
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
        address1: results.billingData.address1,
        address2: results.billingData.address2,
        city: results.billingData.city,
        state: results.billingData.state,
        zip: results.billingData.zip,
        country_id: results.billingData.country_id,
        account_holders_name: results.bankAccountData.account_name
      })
    });

    this._modalService
          .openConfirmationModal(ModalComponent, this.activateBalanceModal, {}, {
            modalTitle: 'Activate Balance',
            template: this.activateBalanceModalForm,
            showFooter: true,
            saveButtonLabel: 'Activate balance',
            size: 'modal-lg'
          })
          .subscribe((v) => {
            this._store.activateBalance(this.activateBalanceForm.value).subscribe()
           alert('here')
          });
  }
}
