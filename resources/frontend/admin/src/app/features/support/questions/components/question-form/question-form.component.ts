import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { SupportQuestionFormStore } from '../../../../../store/support/questions/form.store';
import { Question } from '../../../../../types/support/question';

@Component({
  selector: 'app-form',
  standalone: false,
  templateUrl: './question-form.component.html',
  styleUrl: './question-form.component.scss',
  providers: [SupportQuestionFormStore]
})
export class QuestionFormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  _formStore = inject(SupportQuestionFormStore)
  vm$ = this._formStore.vm$

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {

    this.initializeForm();

    if (this.formData?.id) {
      this.patchForm();
    }

    this._formStore.getCategories()
  }
  save() {
    if (this.form?.valid) {
      const model: Question = {
        question: this.form.value.question,
        answer: this.form.value.answer,
        category_id: this.form.value.category_id
      } as Question;

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
      question: this.formData.question,
      answer: this.formData.answer,
      category_id: this.formData.category_id
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl<number | null>(null),
      question: new FormControl<string>('', [Validators.required]),
      answer: new FormControl<string>('', [Validators.required]),
      category_id: new FormControl<string>('', [Validators.required]),
    })
  }
}
