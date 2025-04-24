import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {firstValueFrom, forkJoin} from 'rxjs';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {LookupStore} from "../../../../store/lookup.store";
import {ProductFormStore} from "../../../../store/products/form.store";
import {Product} from "../../../../types/products/product";
import {StockStatusEnum} from '../../../../types/products/stock-status.enum';
import {FeaturedEnum} from '../../../../types/products/featured.enum';
import {AuthService} from '../../../../core/auth/auth.service';
import {AttributeValue} from '../../../../types/attribute-values/attribute-value';

@Component({
  selector: 'app-form',
  standalone: false,
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
  private _authService = inject(AuthService)
  private attributeValues: AttributeValue[] = [];

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

    this._lookupStore.attributes$.subscribe(result => {
      this.attributeValues = result.map(x => x.attribute_values).flatMap(e => [...e])

      if (this.attributeValues && this.attributeValues.length) {
        this.attributeValues.forEach((result: AttributeValue) => {
          const productAttribute = this.formData?.product_attributes && this.formData?.product_attributes.length ? this.formData.product_attributes.find(x => x.attribute_value_id === result.id) : false

          this.form.addControl(`attribute-${result.id}`, new FormControl(!!productAttribute));
        })
      }
    })

    if (this.formData?.id) {
      this.patchForm();
    }

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });
  }

  async save() {
    const file = await firstValueFrom(this._formStore.file$)

    const user = this._authService.GetUser()

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
        featured: this.form.value.featured === 'yes' ? 1 : 0,
        seller_id: Number(user.payload.id),
        images: ''
      } as Product;

      if (file) {
        model.image = file
      }

      if (this.form.value.id) {
        model.id = this.form.value.id
      }

      model.attributes = this.attributeValues.map((result: AttributeValue) => {
          return {
            attribute_id: result.attribute_id,
            attribute_value_id: result.id,
            selected: this.form.value[`attribute-${result.id}`] === true
          }
      });

      this._formStore.saveData(model).subscribe(result => {
        this.confirm();
      })
    }
  }

  patchForm() {
    console.log('form data', this.formData)
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
      sku: this.formData.SKU,
      quantity: this.formData.quantity,
      stock_status: this.formData.has_stock === true ? 'instock' : 'outofstock',
      featured: this.formData.featured === 0 ? 'no' : 'yes',
    })

    if (this.formData.category_id) {
      this._formStore.getSubcategories(this.formData.category_id)
    }

    this._formStore.updateImagePreview(this.formData.image)
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
      image: new FormControl(''),
    })
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }

  protected readonly StockStatus = StockStatusEnum;
  protected readonly FeaturedEnum = FeaturedEnum;
}
