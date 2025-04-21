import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Slide} from '../../../../data/slide';
import {SlideFormStore} from '../../store/form.store';
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
  _formStore = inject(SlideFormStore)
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
  }
  save() {
    if (this.form?.valid) {
      const model: Slide = {
        title: this.form.value.title,
        subtitle: this.form.value.subtitle,
        tags: this.form.value.tags,
        link: this.form.value.link,
        link_text: this.form.value.link_text,
        active: this.form.value.active,
        image: this.form.value.image,
      } as Slide;

      this._formStore.saveData(model).subscribe(result => {
        alert('good')
        this.confirm();
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      title: this.formData.title,
      subtitle: this.formData.subtitle,
      tags: this.formData.tags,
      link: this.formData.link,
      link_text: this.formData.link_text,
      active: this.formData.active,
      image: this.formData.image,
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      title: new FormControl<string>('', [Validators.required]),
      subtitle: new FormControl<string>('', [Validators.required]),
      tags: new FormControl<string>('', [Validators.required]),
      link: new FormControl<string>('', [Validators.required]),
      link_text: new FormControl<string>('', [Validators.required]),
      active: new FormControl<string>('', [Validators.required]),
      image: new FormControl<string>(''),
    })
  }
}
