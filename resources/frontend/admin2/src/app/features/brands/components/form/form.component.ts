import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Brand} from '../../../../data/brand';
import {LookupStore} from '../../../../shared/store/lookup.store';
import {BrandFormStore} from '../../store/form.store';
import {FormSubmitDirective} from '../../../../directives/form-submit.directive';
import {FieldValidationFlagDirective} from '../../../../directives/field-validation-flag.directive';

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

  save() {
    if (this.form?.valid) {
      const model: Brand = {
        name: this.form.value.name,
        slug: this.form.value.slug,
        image: this.form.value.image
      } as Brand;

      this._formStore.saveData(model).subscribe(result => {
        alert('here')
        this.confirm();
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      slug: this.formData.slug,
      image: this.formData.image
    })
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
}
