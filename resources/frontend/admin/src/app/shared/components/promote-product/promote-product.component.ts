import { Component } from '@angular/core';
import { ModalComponent } from '../modal/modal.component';
import { of } from 'rxjs';

@Component({
  selector: 'app-promote-product',
  standalone: false,
  templateUrl: './promote-product.component.html',
  styleUrl: './promote-product.component.scss'
})
export class PromoteProductComponent extends ModalComponent {
  days: number

  public changeBumpDays = ($event: Event) => {
    const input = $event.target as HTMLInputElement

    if (input.checked) {
      this.days = Number(input.value)
    }
  }

  async confirm() {
   
  }
}
