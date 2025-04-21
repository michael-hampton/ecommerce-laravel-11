import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Product} from '../../../../data/product';
import {ProductFormStore} from '../../store/form.store';
import {LookupStore} from '../../../../shared/store/lookup.store';
import {NgbAccordionBody, NgbAccordionButton, NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {CategoryFormStore} from '../../../categories/store/form.store';
import {FormSubmitDirective} from '../../../../directives/form-submit.directive';
import {FieldValidationFlagDirective} from '../../../../directives/field-validation-flag.directive';
import {catchError, forkJoin, of} from 'rxjs';

@Component({
  selector: 'app-form',
  imports: [
    CommonModule,
    ModalComponent,
    ReactiveFormsModule,
    FieldValidationFlagDirective,
    FormSubmitDirective

  ],
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss'
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  private _lookupStore = inject(LookupStore);
  lookupVm$ = this._lookupStore.vm$;
  _formStore = inject(ProductFormStore)
  formVm$ = this._formStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    forkJoin([
      this._lookupStore.getCategories(),
      this._lookupStore.getBrands(),
      this._lookupStore.getAttributes()
    ]);

    this.initializeForm();

    if (this.formData?.id) {
      this.patchForm();
    }

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });

    this.form?.controls['category_id'].valueChanges.subscribe(value => {
      this._lookupStore.getSubcategories(value)
    });
  }
  save() {
    if (this.form?.valid) {
      const model: Product = {
        name: this.form.value.name,
        short_description: this.form.value.short_description,
        description: this.form.value.description,
        slug: this.form.value.slug,
        category_id: this.form.value.category_id,
        subcategory_id: this.form.value.subcategory_id,
        brand_id: this.form.value.brand_id,
        regular_price: this.form.value.regular_price,
        sale_price: this.form.value.sale_price,
        SKU: this.form.value.sku,
        quantity: this.form.value.quantity,
        stock_status: this.form.value.stock_status,
        featured: this.form.value.featured,
        image: this.form.value.image,
        seller_id: 1, //TODO
        images: ''
      } as Product;

      this._formStore.saveData(model).subscribe(result => {
        this.confirm();
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      short_description: this.formData.short_description,
      description: this.formData.description,
      slug: this.formData.slug,
      category_id: this.formData.category_id,
      subcategory_id: this.formData.subcategory_id,
      brand_id: this.formData.brand_id,
      regular_price: this.formData.regular_price,
      sale_price: this.formData.sale_price,
      sku: this.formData.sku,
      quantity: this.formData.quantity,
      stock_status: this.formData.stock_status,
      featured: this.formData.featured,
      image: this.formData.image,
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      short_description: new FormControl('', [Validators.required]),
      description: new FormControl('', [Validators.required]),
      slug: new FormControl('', [Validators.required]),
      category_id: new FormControl('', [Validators.required]),
      subcategory_id: new FormControl(''),
      brand_id: new FormControl('', [Validators.required]),
      regular_price: new FormControl(0, [Validators.required]),
      sale_price: new FormControl(0),
      sku: new FormControl('', [Validators.required]),
      quantity: new FormControl(1, [Validators.required]),
      stock_status: new FormControl('', [Validators.required]),
      featured: new FormControl('', [Validators.required]),
      image: new FormControl('', [Validators.required]),
    })
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }
}
