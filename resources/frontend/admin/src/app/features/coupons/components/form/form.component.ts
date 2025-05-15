import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {LookupStore} from "../../../../store/lookup.store";
import {ModalComponent} from "../../../../shared/components/modal/modal.component";
import {CouponFormStore} from "../../../../store/coupons/form.store";
import {Coupon} from "../../../../types/coupons/coupon";
import {CouponTypeEnum} from '../../../../types/coupons/coupon-type.enum';
import {futureValidator} from '../../../../core/input/validators';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [CouponFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$;
  _formStore = inject(CouponFormStore)

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {
    this.initializeForm();

    this._lookupStore.getCategories();
    this._lookupStore.getBrands();

    if (this.formData?.id) {
      this.patchForm();
    }
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

      if (this.form.value.id) {
        model.id = this.form.value.id
      }

      this._formStore.saveData(model).subscribe(result => {
        this.confirm();
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
      categories: this.formData.categories.map(x => x.id),
      brands: this.formData.brands.map(x => x.id),
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      code: new FormControl('', [Validators.required]),
      type: new FormControl('', [Validators.required]),
      value: new FormControl('', [Validators.required]),
      cart_value: new FormControl('', [Validators.required]),
      usages: new FormControl(1),
      expires_at: new FormControl(null, futureValidator),
      categories: new FormControl(''),
      brands: new FormControl(''),
    })
  }

  protected readonly CouponTypeEnum = CouponTypeEnum;
}
