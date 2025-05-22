import { ChangeDetectionStrategy, Component, ElementRef, inject, OnInit, TemplateRef, ViewChild, ViewContainerRef } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { firstValueFrom, forkJoin } from 'rxjs';
import { ModalComponent } from '../modal/modal.component';
import { LookupStore } from "../../../store/lookup.store";
import { ProductFormStore } from "../../../store/products/form.store";
import { Product } from "../../../types/products/product";
import { StockStatusEnum } from '../../../types/products/stock-status.enum';
import { FeaturedEnum } from '../../../types/products/featured.enum';
import { AuthService } from '../../../core/auth/auth.service';
import { AttributeValue } from '../../../types/attribute-values/attribute-value';
import { PackageSizeEnum } from '../../../types/products/package-size.enum';
import { ModalService } from '../../../services/modal.service';
import { BumpProductComponent } from '../../../features/products/components/bump-product/bump-product.component';


@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './product-form.component.html',
  styleUrl: './product-form.component.scss',
  providers: [ProductFormStore],
  changeDetection: ChangeDetectionStrategy.OnPush
})
export class ProductFormComponent extends ModalComponent implements OnInit {
  @ViewChild('username') input: TemplateRef<any>

  form?: FormGroup;

  private _lookupStore = inject(LookupStore);
  lookupVm$ = this._lookupStore.vm$;
  _formStore = inject(ProductFormStore)
  formVm$ = this._formStore.vm$;
  private _authService = inject(AuthService)
  private attributeValues: AttributeValue[] = [];
  testModal: any;

  private _modalService = inject(ModalService)

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {
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

    this._formStore.files$.subscribe(result => {
      this.form.patchValue({
        imagesSource: result
      });
    });

    if (this.formData?.id) {
      this.patchForm();
    }

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });

    this.form?.controls['category_id'].valueChanges.subscribe(value => {
      if (value) {
        this._lookupStore.getAttributesForCategory(value)
      }
    });

    this.form?.controls['featured'].valueChanges.subscribe(value => {
      if (value === 'yes') {
        this._modalService
          .openModal(BumpProductComponent, this.formData, { modalTitle: 'Bump Product', size: 'modal-md', callback: (data) => this.bumpProduct(data) })
          .subscribe((v) => {
            this._modalService.closeModal();
          });
      }
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
        package_size: this.form.value.package_size,
        stock_status: this.form.value.stock_status,
        featured: this.form.value.featured === 'yes' ? 1 : 0,
        seller_id: Number(user.payload.id),
        bump_days: this.form.value.bump_days,
        active: this.form.value.active === true ? 0 : 1,
      } as Product;

      if (this.form.value.imagesSource) {
        model.images = this.form.value.imagesSource
      }

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
      package_size: this.formData.package_size,
      stock_status: this.formData.has_stock === true ? 'instock' : 'outofstock',
      featured: this.formData.featured === 0 ? 'no' : 'yes',
      active: this.formData.active === true ? false : true,
    })

    if (this.formData.category_id) {
      this._formStore.getSubcategories(this.formData.category_id)
    }

    this._formStore.updateImagePreview(this.formData.image)
    this._formStore.updateImageGallery(this.formData.images)
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
      package_size: new FormControl('', [Validators.required]),
      stock_status: new FormControl('', [Validators.required]),
      featured: new FormControl('', [Validators.required]),
      image: new FormControl(''),
      images: new FormControl(''),
      imagesSource: new FormControl(''),
      bump_days: new FormControl(''),
      active: new FormControl(false)
    })
  }

  bumpProduct(data: any) {
    this.form.patchValue({ bump_days: data.days })
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({ slug: value })
  }

  protected readonly StockStatus = StockStatusEnum;
  protected readonly FeaturedEnum = FeaturedEnum;
  protected readonly PackageSizeEnum = PackageSizeEnum;
}
