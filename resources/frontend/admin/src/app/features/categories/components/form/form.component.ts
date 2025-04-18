import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {ModalComponent} from '../../../../shared/modal/modal.component';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {Category} from '../../../../data/category';
import {LookupStore} from '../../../../shared/store/lookup.store';
import {CategoryFormStore} from '../../store/form.store';

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
  _formStore = inject(CategoryFormStore)
  formVm$ = this._formStore.vm$;
  lookupVm$ = this._lookupStore.vm$;

  public constructor(private fb: FormBuilder) {
    super();
  }

  override ngOnInit() {
    super.ngOnInit();

    this.initializeForm();

    this._lookupStore.getCategories();

    if (this.formData?.id) {
      this.patchForm();
    }

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });
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
      const model: Category = {
        name: this.form.value.name,
        slug: this.form.value.slug,
        image: this.form.value.image,
        parent_id: this.form.value.parent_id
      } as Category;

      this._formStore.saveData(model).subscribe(result => {
        alert('here')
      });
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      slug: this.formData.slug,
      image: this.formData.image,
      parent_id: this.formData.parent_id,
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      slug: new FormControl('', [Validators.required]),
      image: new FormControl(''),
      parent_id: new FormControl(''),
    });
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }
}
