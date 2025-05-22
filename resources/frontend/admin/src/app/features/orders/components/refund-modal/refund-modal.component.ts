import { Component, inject, OnInit } from '@angular/core';
import { OrderDetailsStore } from '../../../../store/orders/order-details.store';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FormBuilder, FormControl, FormGroup, Validators } from '@angular/forms';
import { OrderItem } from '../../../../types/orders/orderItem';

@Component({
  selector: 'app-refund-modal',
  standalone: false,
  templateUrl: './refund-modal.component.html',
  styleUrl: './refund-modal.component.scss',
  providers: [OrderDetailsStore]
})
export class RefundModalComponent extends ModalComponent implements OnInit {
  private _store = inject(OrderDetailsStore)
  form?: FormGroup;
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  line: OrderItem;
  ngOnInit() {
    this.initForm()
    this._store.filterMessages(this.formData.orderItemId)

    this._store.orderLines$.subscribe((orderLines) => {
      this.line = orderLines.find(x => x.id === this.formData.orderItemId)

      if (this.line) {
        this.form?.patchValue({ amount: this.calculatedAmount })
      }
    })

    this.form.controls['action'].valueChanges.subscribe(value => {
      if (value === 'partial_amount') {
        this.form?.patchValue({ amount: this.calculatedAmount })
        this.form.controls['amount'].enable();
      }

      if (value === 'full_amount') {
        this.form?.patchValue({ amount: this.calculatedAmount })
        this.form.controls['amount'].disable();

      }
    });
  }

  get calculatedAmount() {
    let total = parseFloat(this.line?.price) * this.line?.quantity + parseFloat(this.line?.shipping)

    return (Math.round(total * 100) / 100).toFixed(2);
  }

  get shippingCost() {
    return parseFloat(this.line?.shipping);
  }

  initForm() {
    this.form = this.fb.group({
      id: new FormControl(null),
      amount: new FormControl('', [Validators.required]),
      action: new FormControl('full_amount', Validators.required),
      buyer_pays_return_postage: new FormControl(true, Validators.required)
    });

    this.form.controls['amount'].disable();
  }

  save() {
    this._store.refundLine(this.form.getRawValue(), this.formData.orderItemId).subscribe()
  }
}
