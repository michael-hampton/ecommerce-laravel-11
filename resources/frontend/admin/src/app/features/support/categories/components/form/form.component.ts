import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import { SupportCategoryFormStore } from '../../../../../store/support/categories/form.store';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { Category } from '../../../../../types/support/category';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [SupportCategoryFormStore]
})
export class FormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  _formStore = inject(SupportCategoryFormStore)

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {

    this.initializeForm();

    this.form?.controls['name'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });

    if (this.formData?.id) {
      this.patchForm();
    }
  }
  save() {
    if (this.form?.valid) {
      const model: Category = {
        name: this.form.value.name,
        slug: this.form.value.slug
      } as Category;

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
      slug: this.formData.slug
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      name: new FormControl('', [Validators.required]),
      slug: new FormControl('', [Validators.required]),
    })
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }
}
