import { Component, inject } from '@angular/core';
import { Review } from '../../../../types/seller/review';
import { AbstractControl, FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ProfileStore } from '../../../../store/profile/form.store';

@Component({
  selector: 'app-reviews',
  standalone: false,
  templateUrl: './reviews.component.html',
  styleUrl: './reviews.component.scss'
})
export class ReviewsComponent {
  ordersForm!: FormGroup;
  private _store = inject(ProfileStore)
  vm$ = this._store.vm$

  constructor(
    private readonly formBuilder: FormBuilder
  ) { }

  ngOnInit() {
    this.ordersForm = this.formBuilder.group({
      reviews: this.formBuilder.array([])
    });

    this._store.getReviews().subscribe((reviews: Review[]) => {
      reviews.forEach(review => {
        let row = this.formBuilder.group({
          id: [review.id],
          reply: [null, Validators.required],
        });

        this.reviews.push(row);
      });
    })
  }

  get reviews(): FormArray {
    return (this.ordersForm.get('reviews') as FormArray);
  }

  getFormGroupAtIndex(reviewId: number) {
    return this.rowsControls.filter(x => x.get('id').value === reviewId)[0] as FormGroup
  }

  get rowsControls(): AbstractControl[] {
    return this.reviews.controls;
  }

  submitReview(reviewId: number) {
    const row = this.getFormGroupAtIndex(reviewId).value
    
    this._store.saveReviewReply({reviewId: row.id, reply: row.reply}).subscribe()
  }
}
