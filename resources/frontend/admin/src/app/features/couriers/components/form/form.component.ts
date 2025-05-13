import { Component, ElementRef, inject, OnInit, ViewChild } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { LookupStore } from "../../../../store/lookup.store";
import { CourierFormStore } from "../../../../store/couriers/form.store";
import { Courier } from '../../../../types/couriers/courier';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [CourierFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  _store = inject(CourierFormStore)
  vm$ = this._store.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();
    this._store.getCountries(true)

    if (this.formData?.id) {
      this.patchForm();
    }
  }

  async save() {  
    if (this.form?.valid) {
      const model: Courier = {
        id: this.form.value.id,
        name: this.form.value.name,
        code: this.form.value.code,
        country_id: this.form.value.country_id,
        active: this.form.value.active === true
      } as Courier;

      if (this.form.value.id) {
        model.id = this.form.value.id
      }

      this._store.saveData(model).subscribe(result => {
        this.confirm();
      })
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      country_id: this.formData.country_id,
      active: this.formData.active,
      code: this.formData.code
    })

  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      country_id: new FormControl('', [Validators.required]),
      active: new FormControl(true),
      code: new FormControl('')
    })
  }
}
