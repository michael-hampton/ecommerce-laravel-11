import { Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import {ModalComponent} from "../../../../shared/components/modal/modal.component";
import {Attribute} from "../../../../types/attributes/attribute";
import {AttributeFormStore} from "../../../../store/attributes/form.store";

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [AttributeFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;
  _formStore = inject(AttributeFormStore)

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {
    this.initializeForm();

    if(this.formData?.id) {
      this.patchForm();
    }
  }

  save() {
    if (this.form?.valid) {
      const model: Attribute = {
        name: this.form.value.name,
      } as Attribute;

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
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      name: new FormControl<string>('', [Validators.required]),
    })
  }
}
