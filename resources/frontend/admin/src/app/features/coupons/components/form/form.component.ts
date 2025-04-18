import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Coupon} from '../../../../data/coupon';
import {LookupStore} from '../../../../shared/store/lookup.store';
import {CouponFormStore} from '../../store/form.store';

@Component({
  selector: 'app-form',
  imports: [
    CommonModule,
    ModalComponent,
    ReactiveFormsModule
  ],
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss'
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$;
  _formStore = inject(CouponFormStore)
  formVm$ = this._formStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();

    this._lookupStore.getCategories();
    this._lookupStore.getBrands();

    if (this.formData?.id) {
      this.patchForm();
    }
  }

  open = () => {
    console.log('content', this.content)
    console.log('service', this.modalService)
    // super.open();
    return Promise.resolve();
  }

  override close() {
    super.close();
  }

  save() {
    if (this.form?.valid) {
      const model: Coupon = {
        code: this.form.value.code,
        type: this.form.value.type,
        value: this.form.value.value,
        cart_value: this.form.value.cart_value,
        usages: this.form.value.usages,
        expires_at: this.form.value.expires_at,
        categories: this.form.value.categories,
        brands: this.form.value.brands,
      } as Coupon;

      this._formStore.saveData(model).subscribe(result => {
        alert('good');
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      code: this.formData.code,
      type: this.formData.type,
      value: this.formData.value,
      cart_value: this.formData.cart_value,
      usages: this.formData.usages,
      expires_at: this.formData.expires_at,
      categories: this.formData.categories,
      brands: this.formData.brands,
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      code: new FormControl('', [Validators.required]),
      type: new FormControl('', [Validators.required]),
      value: new FormControl('', [Validators.required]),
      cart_value: new FormControl('', [Validators.required]),
      usages: new FormControl(0),
      expires_at: new FormControl(0),
      categories: new FormControl(''),
      brands: new FormControl(''),
    })
  }
}
