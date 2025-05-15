import {Component, ElementRef, inject, OnInit, ViewChild} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, Validators} from '@angular/forms';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { SupportArticleFormStore } from '../../../../store/support/articles/form.store';
import { Article } from '../../../../types/support/article';

@Component({
  selector: 'app-article-form',
  standalone: false,
  templateUrl: './article-form.component.html',
  styleUrl: './article-form.component.scss',
  providers: [SupportArticleFormStore]
})
export class ArticleFormComponent extends ModalComponent implements OnInit {
  @ViewChild('modal') content!: ElementRef;
  form?: FormGroup;

  _formStore = inject(SupportArticleFormStore)
  vm$ = this._formStore.vm$

  public constructor(private fb: FormBuilder) {
    super();
  }

  ngOnInit() {

    this.initializeForm();

    this.form?.controls['title'].valueChanges.subscribe(value => {
      this.stringToSlug(value)
    });

    if (this.formData?.id) {
      this.patchForm();
    }

    this._formStore.getCategories()
    this._formStore.getTags()
  }
  save() {
    if (this.form?.valid) {
      const model: Article = {
        title: this.form.value.title,
        slug: this.form.value.slug,
        short_text: this.form.value.short_text,
        full_text: this.form.value.full_text,
        tags: this.form.value.tags,
        category_id: this.form.value.category_id
      } as Article;

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
      slug: this.formData.slug,
      short_text: this.formData.short_text,
      full_text: this.formData.full_text,
      tags: this.formData.tag_ids,
      category_id: this.formData.category_id
    })
  }

  initializeForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      title: new FormControl('', [Validators.required]),
      short_text: new FormControl('', [Validators.required]),
      full_text: new FormControl('', [Validators.required]),
      tags: new FormControl('', []),
      slug: new FormControl('', [Validators.required]),
      category_id: new FormControl('', [Validators.required]),
    })
  }

  stringToSlug(text: string) {
    var value = text.toLowerCase()
      .replace(/[^\w ]+/g, "")
      .replace(/ +/g, "-");

    this.form?.patchValue({slug: value})
  }
}
