import {Component, inject} from '@angular/core';
import {ProfileStore} from '../../../../store/profile/form.store';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {Seller} from '../../../../types/seller/seller';

@Component({
  selector: 'app-setting-page',
  standalone: false,
  templateUrl: './setting-page.component.html',
  styleUrl: './setting-page.component.scss'
})
export class SettingPageComponent {

  private _store = inject(ProfileStore)
  vm$ = this._store.vm$
  form?: FormGroup;
  private fb = inject(FormBuilder)

  ngOnInit() {
    this.initForm();

    this._store.getData(1).subscribe(result => {
      this.form?.patchValue({
        id: result.data.id,
        name: result.data.name,
        email: result.data.email,
        phone: result.data.mobile,
        username: result.data.username,
        address1: result.data.address1,
        address2: result.data.address2,
        city: result.data.city,
        state: result.data.state,
        zip: result.data.zip,
        bio: result.data.bio,
        active: result.data.active,
        image: result.data.image
      })
    })
  }

  save() {
      alert('saving')

    if (this.form?.valid) {
      const model: Seller = {
        name: this.form.value.name,
        email: this.form.value.email,
        mobile: this.form.value.phone,
        username: this.form.value.username,
        address1: this.form.value.address1,
        address2: this.form.value.address2,
        city: this.form.value.city,
        state: this.form.value.state,
        zip: this.form.value.zip,
        bio: this.form.value.bio,
        active: true,
        image: this.form.value.image
      } as Seller;

      console.log('model', model)

      this._store.saveData(model).subscribe(result => {
        alert('good');
      })
    }
  }

  initForm() {
    this.form = this.fb.group({
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
}
