import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';
import {AccountDetails} from '../../../../types/seller/account-details';
import {Billing} from '../../../../types/seller/billing';

@Component({
  selector: 'app-billing',
  standalone: false,
  templateUrl: './billing.component.html',
  styleUrl: './billing.component.scss',
  providers: [ProfileStore]
})
export class BillingComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  form: FormGroup;

  ngOnInit() {
    this.initBillingForm();

    this._store.getBilling().subscribe((result: Billing) => {
      this.form.patchValue({
        address1: result.address1,
        address2: result.address2,
        city: result.city,
        state: result.state,
        zip: result.zip,
        country_id: result.country_id,
      })
    })
  }

  saveBilling() {
    if (this.form?.valid) {
      const model: Seller = {
        address1: this.form.value.address1,
        address2: this.form.value.address2,
        city: this.form.value.city,
        state: this.form.value.state,
        zip: this.form.value.zip,
      } as Seller;

      console.log('model', model)

      this._store.saveBilling(model).subscribe(result => {
        alert('good');
      })
    }
  }

  initBillingForm() {
    this.form = this.fb.group({
      address1: new FormControl(''),
      address2: new FormControl(''),
      city: new FormControl(''),
      state: new FormControl(''),
      zip: new FormControl(''),
      country_id: new FormControl(''),
    })
  }
}
