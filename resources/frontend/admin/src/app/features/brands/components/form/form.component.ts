import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {LookupStore} from "../../../../store/lookup.store";
import {BrandFormStore} from "../../../../store/brands/form.store";
import {Brand} from '../../../../types/brands/brand';
import {firstValueFrom} from 'rxjs';

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
    if (this.form?.valid) {
      const file = await firstValueFrom(this._formStore.file$)
      const model: Brand = {
        name: this.form.value.name,
        slug: this.form.value.slug,
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
      //image: this.formData.image
    })

    this._formStore.addImage(this.formData.image)
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      name: new FormControl<string>('', [Validators.required]),
      slug: new FormControl<string>('', [Validators.required]),
      image: new FormControl<string>(''),
    })
  }

  stringToSlug(text: string) {
    const value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }

  async getImageUrl() {
    const imagePreview = await firstValueFrom(this._formStore.image$)
    return !imagePreview || !imagePreview.length ? this.form.controls['image'].value : imagePreview
  }
}
