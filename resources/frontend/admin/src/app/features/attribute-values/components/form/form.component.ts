import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {LookupStore} from "../../../../store/lookup.store";
import {AttributeValueFormStore} from '../../../../store/attribute-values/form.store';
import {AttributeValue} from '../../../../types/attribute-values/attribute-value';

@Component({
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  standalone: false
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$;
  _formStore = inject(AttributeValueFormStore)

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
  save() {
    if (this.form?.valid) {
      const model: AttributeValue = {
        name: this.form.value.name,
        attribute_id: this.form.value.attribute_id
      } as AttributeValue;

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
