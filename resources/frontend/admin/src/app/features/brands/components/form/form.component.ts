import { Component, ElementRef, inject, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { LookupStore } from "../../../../store/lookup.store";
import { BrandFormStore } from "../../../../store/brands/form.store";
import { Brand } from '../../../../types/brands/brand';
import { firstValueFrom } from 'rxjs';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [BrandFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  private _lookupStore = inject(LookupStore)
  _formStore = inject(BrandFormStore)
  formVm$ = this._formStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();

    if (this.formData?.id) {
      this.patchForm();
    }

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });
  }

  async save() {
    const file = await firstValueFrom(this._formStore.file$)
    if (file || this.formData?.image.length) {
      this.form.controls['image'].setErrors(null);

    }

    if (this.form?.valid) {
      const model: Brand = {
        name: this.form.value.name,
        slug: this.form.value.slug,
        meta_title: this.form.value.meta_title ?? '',
        meta_description: this.form.value.meta_description ?? '',
        meta_keywords: this.form.value.meta_keywords ?? '',
        description: this.form.value.description ?? '',
        active: this.form.value.active === true ? 1 : 0
      } as Brand;

      if (file) {
        model.image = file
      }

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
      name: this.formData.name,
      slug: this.formData.slug,
      meta_title: this.formData.meta_title ?? '',
      meta_description: this.formData.meta_description ?? '',
      meta_keywords: this.formData.meta_keywords ?? '',
      description: this.formData.description ?? '',
      active: this.formData.active
    })

    this._formStore.addImage(this.formData.image)
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      name: new FormControl<string>('', [Validators.required]),
      slug: new FormControl<string>('', [Validators.required]),
      image: new FormControl<string>('', [Validators.required]),
      meta_title: new FormControl(''),
      meta_description: new FormControl(''),
      meta_keywords: new FormControl(''),
      description: new FormControl(''),
      active: new FormControl(true)
    })
  }

  stringToSlug(text: string) {
    const value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({ slug: value })
  }

  async getImageUrl() {
    const imagePreview = await firstValueFrom(this._formStore.image$)
    return !imagePreview || !imagePreview.length ? this.form.controls['image'].value : imagePreview
  }
}
