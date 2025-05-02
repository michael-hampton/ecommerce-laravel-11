import { Component, ElementRef, inject, OnInit, ViewChild } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { ModalComponent } from "../../../../shared/components/modal/modal.component";
import { SlideFormStore } from "../../../../store/slides/form.store";
import { Slide } from "../../../../types/slides/slide";
import { firstValueFrom } from 'rxjs';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './form.component.html',
  styleUrl: './form.component.scss',
  providers: [SlideFormStore]
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
  async save() {
    const file = await firstValueFrom(this._formStore.file$)
    if (file || this.formData?.image.length) {
      this.form.controls['image'].setErrors(null);
    }

    if (this.form?.valid) {

      const model: Slide = {
        title: this.form.value.title,
        subtitle: this.form.value.subtitle,
        tags: this.form.value.tags,
        link: this.form.value.link,
        link_text: this.form.value.link_text,
        active: this.form.value.active === true ? 1 : 0
      } as Slide;

      if (file) {
        model.image = file
      }

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
      title: this.formData.title,
      subtitle: this.formData.subtitle,
      tags: this.formData.tags,
      link: this.formData.link,
      link_text: this.formData.link_text,
      active: this.formData.active,
      //image: this.formData.image,
    })

    this._formStore.addImage(this.formData.image)
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      title: new FormControl('', [Validators.required]),
      subtitle: new FormControl('', [Validators.required]),
      tags: new FormControl('', [Validators.required]),
      link: new FormControl('', [Validators.required]),
      link_text: new FormControl('', [Validators.required]),
      active: new FormControl(true, [Validators.required]),
      image: new FormControl('', [Validators.required]),
    })
  }
}
