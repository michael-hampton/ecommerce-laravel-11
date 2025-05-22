import { Component, inject } from '@angular/core';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { ProductFormStore } from '../../../../store/products/form.store';

@Component({
  selector: 'app-bump-product',
  standalone: false,
  templateUrl: './bump-product.component.html',
  styleUrl: './bump-product.component.scss',
  providers: [ProductFormStore]
})
export class BumpProductComponent extends ModalComponent {
  days: number
  _store = inject(ProductFormStore)

  public changeBumpDays = ($event: Event) => {
    const input = $event.target as HTMLInputElement

    this.days = Number(input.value)

    if (this.callback) {
      this.callback({ days: this.days })
    }
  }

  save() {
    if (this.callback) {
      return this.confirm()
    }

    console.log(this.formData)

    
    this._store.bumpProduct({ days: this.days }, this.formData.id).subscribe()
    return this.confirm()
  }
}
