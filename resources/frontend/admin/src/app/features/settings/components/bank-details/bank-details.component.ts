import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {AccountDetails} from '../../../../types/seller/account-details';

@Component({
  selector: 'app-bank-details',
  standalone: false,
  templateUrl: './bank-details.component.html',
  styleUrl: './bank-details.component.scss',
  providers: [ProfileStore]
})
export class BankDetailsComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;

  ngOnInit() {
    this.initBankDetailsForm();

    this._store.getSellerBankAccountDetails().subscribe((result: AccountDetails) => {
      console.log('res', result)
      this.form.patchValue({
        accountHolderName: result.account_name,
        accountNumber: result.account_number,
        routingNumber: result.sort_code,
        bankName: result.bank_name,
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

      this._store.saveBankDetails(model).subscribe(result => {
        alert('good');
      })
    }
  }

  initBankDetailsForm() {
    this.form = this.fb.group({
      accountHolderName: new FormControl('', [Validators.required]),
      accountNumber: new FormControl('', [Validators.required]),
      routingNumber: new FormControl('', [Validators.required]),
      bankName: new FormControl('', [Validators.required]),
    })
  }
}
