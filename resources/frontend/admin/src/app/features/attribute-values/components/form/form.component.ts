import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {AttributeValue} from '../../../../data/attribute-value';
import {LookupStore} from '../../../../shared/store/lookup.store';
import {AttributeValueFormStore} from '../../store/form.store';

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
  _formStore = inject(AttributeValueFormStore)
  formVm$ = this._formStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();

    this._lookupStore.getAttributes();

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
      const model: AttributeValue = {
        name: this.form.value.name,
        attribute_id: this.form.value.attribute_id
      } as AttributeValue;

      this._formStore.saveData(model).subscribe(result => {
        alert('good');
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      attribute_id: this.formData.attribute_id
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      name: new FormControl<string>('', [Validators.required]),
      attribute_id: new FormControl<string>('', [Validators.required]),
    })
  }
}
