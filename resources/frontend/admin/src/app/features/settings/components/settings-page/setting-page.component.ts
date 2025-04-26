import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';
import {AccountDetails} from '../../../../types/seller/account-details';

@Component({
  selector: 'app-setting-page',
  standalone: false,
  templateUrl: './setting-page.component.html',
  styleUrl: './setting-page.component.scss',
  providers: [ProfileStore]
})
export class SettingPageComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private fb = inject(FormBuilder)
  bankDetailsForm: FormGroup;
  cardDetailsForm: FormGroup;
  withdrawForm: FormGroup;

  ngOnInit() {
    this.initForm();
    this.initBankDetailsForm();
    this.initCardDetailsForm();
    this.initWithdrawBalanceForm()

    this._store.getTransactions().subscribe()
    this._store.getBalance().subscribe()
    this._store.getWithdrawals().subscribe()

    this._store.getSellerBankAccountDetails().subscribe((result: AccountDetails) => {
      console.log('res', result)
      this.bankDetailsForm.patchValue({
        accountHolderName: result.account_name,
        accountNumber: result.account_number,
        routingNumber: result.sort_code,
        bankName: result.bank_name,
      })
    });

    this._store.getSellerCardDetails().subscribe((result: AccountDetails) => {
      this.cardDetailsForm?.patchValue({
        nameOnCard: result.card_name,
        expiry: result.card_expiry_date,
        cvvCode: result.card_cvv,
        cardNumber: result.card_number,
      })
    });

    this._store.getData(1).subscribe((result: Seller) => {
      this.form?.patchValue({
        id: result.id,
        name: result.name,
        email: result.email,
        phone: result.phone,
        username: result.username,
        address1: result.address1,
        address2: result.address2,
        city: result.city,
        state: result.state,
        zip: result.zip,
        bio: result.biography,
        active: result.active,
        image: result.profile_picture
      })
    })
  }

  save() {
    if (this.form?.valid) {
      const model: Seller = {
        name: this.form.value.name,
        email: this.form.value.email,
        phone: this.form.value.phone,
        username: this.form.value.username,
        address1: this.form.value.address1,
        address2: this.form.value.address2,
        city: this.form.value.city,
        state: this.form.value.state,
        zip: this.form.value.zip,
        biography: this.form.value.bio,
        active: true,
        profile_picture: this.form.value.image,
        id: this.form.value.id
      } as Seller;

      console.log('model', model)

      this._store.saveData(model).subscribe(result => {
        alert('good');
      })
    }
  }

  saveCardDetails() {
    if (this.form?.valid) {
      const model = {
        card_name: this.cardDetailsForm.value.nameOnCard,
        card_expiry_date: this.cardDetailsForm.value.expiry,
        card_cvv: this.cardDetailsForm.value.cvvCode,
        card_number: this.cardDetailsForm.value.cardNumber,
      };

      console.log('model', model)

      this._store.saveCardDetails(model).subscribe(result => {
        alert('good');
      })
    }
  }

  saveBankDetails() {
    if (this.form?.valid) {
      const model = {
        account_name: this.bankDetailsForm.value.accountHolderName,
        account_number: this.bankDetailsForm.value.accountNumber,
        sort_code: this.bankDetailsForm.value.routingNumber,
        bank_name: this.bankDetailsForm.value.bankName,
      };

      this._store.saveBankDetails(model).subscribe(result => {
        alert('good');
      })
    }
  }

  initBankDetailsForm() {
    this.bankDetailsForm = this.fb.group({
      accountHolderName: new FormControl('', [Validators.required]),
      accountNumber: new FormControl('', [Validators.required]),
      routingNumber: new FormControl('', [Validators.required]),
      bankName: new FormControl('', [Validators.required]),
    })
  }

  initCardDetailsForm() {
    this.cardDetailsForm = this.fb.group({
      nameOnCard: new FormControl('', [Validators.required]),
      expiry: new FormControl('', [Validators.required]),
      cvvCode: new FormControl('', [Validators.required]),
      cardNumber: new FormControl('', [Validators.required]),
    })
  }

  initWithdrawBalanceForm() {
    this.withdrawForm = this.fb.group({
      amount: new FormControl(0, [Validators.required]),
    })
  }

  initForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      email: new FormControl('', [Validators.email]),
      phone: new FormControl('', [Validators.required]),
      username: new FormControl('', [Validators.required]),
      address1: new FormControl(1),
      address2: new FormControl(0),
      city: new FormControl(''),
      state: new FormControl(''),
      zip: new FormControl(''),
      bio: new FormControl(''),
      image: new FormControl(''),
    })
  }

  withdraw() {
    if (this.withdrawForm.valid) {
      this._store.saveWithdrawal({amount: this.withdrawForm.value.amount}).subscribe(result => {
        this._store.getBalance().subscribe()
      });
    }
    console.log(this.withdrawForm.value)
  }
}
