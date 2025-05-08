import { Component } from '@angular/core';

@Component({
  selector: 'app-balance-page',
  standalone: false,
  templateUrl: './balance-page.component.html',
  styleUrl: './balance-page.component.scss'
})
export class BalancePageComponent {
  page: string = 'balance';

  menuItemChanged(page: string) {
    this.page = page
   }
}
