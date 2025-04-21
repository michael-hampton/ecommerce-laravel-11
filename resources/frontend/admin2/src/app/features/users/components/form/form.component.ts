import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {User} from '../../../../data/user';
import {UserFormStore} from '../../store/form.store';
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
  _formStore = inject(UserFormStore)
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
      const model: User = {
        name: this.form.value.name,
        email: this.form.value.email,
        mobile: this.form.value.mobile,
        password: this.form.value.password,
        utype: this.form.value.utype,
        active: this.form.value.active,
        image: this.form.value.image,
      } as User;

      this._formStore.saveData(model).subscribe(result => {
        alert('good')
        this.confirm()
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      email: this.formData.email,
      mobile: this.formData.mobile,
      password: this.formData.password,
      utype: this.formData.utype,
      active: this.formData.active,
      image: this.formData.image,
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      email: new FormControl('', [Validators.required, Validators.email]),
      mobile: new FormControl('', [Validators.required]),
      password: new FormControl('', [Validators.required]),
      utype: new FormControl('', [Validators.required]),
      active: new FormControl('', [Validators.required]),
      image: new FormControl(''),
    })
  }
}
