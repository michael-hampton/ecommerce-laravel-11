import { Component, inject } from '@angular/core';
import { FormBuilder, FormControl, FormGroup } from '@angular/forms';

@Component({
  selector: 'app-notifications',
  standalone: false,
  templateUrl: './notifications.component.html',
  styleUrl: './notifications.component.scss'
})
export class NotificationsComponent {

  ngOnInit() {
    this.initForm();
  }

  private fb = inject(FormBuilder)
  form: FormGroup;
  
  initForm() {
    this.form = this.fb.group({
      product_added_to_wishlist: new FormControl(true),
      product_in_wishlist_sold: new FormControl(true),
      product_in_wishlist_reduced: new FormControl(true),
      feedback_received: new FormControl(true),
    })
  }
}
