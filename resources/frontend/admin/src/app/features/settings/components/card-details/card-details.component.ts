import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';
import {AccountDetails} from '../../../../types/seller/account-details';
import {Billing} from '../../../../types/seller/billing';

@Component({
  selector: 'app-card-details',
  standalone: false,
  templateUrl: './card-details.component.html',
  styleUrl: './card-details.component.scss',
  providers: [ProfileStore]
})
export class CardDetailsComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;

  ngOnInit() {
    this.initCardDetailsForm();

    this._store.getSellerCardDetails().subscribe((result: AccountDetails) => {
      this.form?.patchValue({
        nameOnCard: result.card_name,
        expiry: result.card_expiry_date,
        cvvCode: result.card_cvv,
        cardNumber: result.card_number,
      })
    });
  }

  saveCardDetails() {
    if (this.form?.valid) {
      const model = {
        card_name: this.form.value.nameOnCard,
        card_expiry_date: this.form.value.expiry,
        card_cvv: this.form.value.cvvCode,
        card_number: this.form.value.cardNumber,
      };

      console.log('model', model)

      this._store.saveCardDetails(model).subscribe(result => {
        alert('good');
      })
    }
  }
  initCardDetailsForm() {
    this.form = this.fb.group({
      nameOnCard: new FormControl('', [Validators.required]),
      expiry: new FormControl('', [Validators.required]),
      cvvCode: new FormControl('', [Validators.required]),
      cardNumber: new FormControl('', [Validators.required]),
    })
  }
}
