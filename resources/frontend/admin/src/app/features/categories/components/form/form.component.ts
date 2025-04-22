import {Component, ElementRef, inject, input, OnInit, ViewChild} from '@angular/core';
import {CommonModule} from '@angular/common';
import {FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators} from '@angular/forms';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {LookupStore} from "../../../../store/lookup.store";
import {CategoryFormStore} from "../../../../store/categories/form.store";
import {Category} from '../../../../types/categories/category';

@Component({
  standalone: false,
  selector: 'app-form',
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
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

  save() {
    if (this.form?.valid) {
      const model: Category = {
        name: this.form.value.name,
        slug: this.form.value.slug,
        image: this.form.value.image,
        parent_id: this.form.value.parent_id,
        meta_title: this.form.value.meta_title,
        meta_description: this.form.value.meta_description,
        meta_keywords: this.form.value.meta_keywords,
      } as Category;

      this._formStore.saveData(model).subscribe(result => {
        this.confirm();
      });
    }
  }

  patchForm() {
    this.form?.patchValue({
      id: this.formData.id,
      name: this.formData.name,
      slug: this.formData.slug,
      //image: this.formData.image,
      parent_id: this.formData.parent_id,
      meta_title: this.formData.meta_title,
      meta_description: this.formData.meta_description,
      meta_keywords: this.formData.meta_keywords,
    })

    this._formStore.addImage(this.formData.image)
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      slug: new FormControl('', [Validators.required]),
      image: new FormControl(''),
      parent_id: new FormControl(''),
      meta_title: new FormControl(''),
      meta_description: new FormControl(''),
      meta_keywords: new FormControl(''),
    });
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }

  protected readonly input = input;
}
