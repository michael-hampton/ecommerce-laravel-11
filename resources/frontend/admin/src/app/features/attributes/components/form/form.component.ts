import {AfterViewInit, Component, ElementRef, inject, OnInit, TemplateRef, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Attribute} from '../../../../data/attribute';
import {AttributeFormStore} from '../../store/form.store';

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
  _formStore = inject(AttributeFormStore)
  formVm$ = this._formStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();

    if(this.formData?.id) {
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
      const model: Attribute = {
        name: this.form.value.name,
      } as Attribute;

      this._formStore.saveData(model).subscribe(result => {
        alert('good');
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
