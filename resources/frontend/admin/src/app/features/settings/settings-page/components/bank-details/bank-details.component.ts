import { Component, inject, ViewChild, ViewContainerRef } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { AccountDetails } from '../../../../../types/seller/account-details';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { ModalService } from '../../../../../services/modal.service';
import { BankDetailsStore } from './bank-details.store';
import { SellerApi } from '../../../../../apis/seller.api';

@Component({
  selector: 'app-bank-details',
  standalone: false,
  templateUrl: './bank-details.component.html',
  styleUrl: './bank-details.component.scss',
  providers: [BankDetailsStore]
})
export class BankDetailsComponent {

  private _store = inject(BankDetailsStore)
  private _api = inject(SellerApi)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;
  private _modalService = inject(ModalService)
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;

  ngOnInit() {
    this.initBankDetailsForm();

    this._api.getSellerBankAccountDetails().subscribe((result: AccountDetails) => {
      this.form.patchValue({
        id: result.id,
        accountHolderName: result.account_name,
        accountNumber: result.account_number,
        routingNumber: result.sort_code,
        bankName: result.bank_name,
      })
    });
  }

  deleteBankAccount() {
    this._modalService
      .openConfirmationModal(ModalComponent, this.entry, this.form.value, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close',
        //size: 'modal-sm'
      })
      .subscribe((v) => {
        this._store.deleteBankAccount(this.form.value.id).subscribe(() => {
          this.form.reset();
        })
      });

  }

  saveBankDetails() {
    if (this.form?.valid) {
      const model = {
        account_name: this.form.value.accountHolderName,
        account_number: this.form.value.accountNumber,
        sort_code: this.form.value.routingNumber,
        bank_name: this.form.value.bankName,
      };

      this._store.saveBankDetails(model).subscribe()
    }
  }

  initBankDetailsForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      accountHolderName: new FormControl('', [Validators.required]),
      accountNumber: new FormControl('', [Validators.required]),
      routingNumber: new FormControl('', [Validators.required]),
      bankName: new FormControl('', [Validators.required]),
    })
  }
}
