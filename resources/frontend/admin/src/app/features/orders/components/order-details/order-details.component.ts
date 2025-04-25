import {Component, inject, OnInit} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from '@angular/forms';
import {OrderDetailsStore} from '../../../../store/orders/order-details.store';
import {SaveOrder} from '../../../../types/orders/save-order';
import {ActivatedRoute} from '@angular/router';
import {OrderStatusEnum} from '../../../../types/orders/orderStatus.enum';
import {OrderDetail} from '../../../../types/orders/order-detail';
import {OrderItem} from '../../../../types/orders/orderItem';

@Component({
  selector: 'app-order-details',
  standalone: false,
  templateUrl: './order-details.component.html',
  styleUrl: './order-details.component.scss',
  providers: [OrderDetailsStore]
})
export class OrderDetailsComponent implements OnInit {

  orderStatusForm: FormGroup;
  private _store = inject(OrderDetailsStore)
  vm$ = this._store.vm$
  private fb = inject(FormBuilder)
  private orderId: number;
  private activatedRoute = inject(ActivatedRoute)
  private orderLines: any;
  protected readonly OrderStatusEnum = OrderStatusEnum;

  ngOnInit(): void {
    this.initializeForm()

    this.activatedRoute.params.subscribe(params => {
      this.orderId = params['id'];
    })

    this._store.getOrderDetails(this.orderId).subscribe((result: OrderDetail) => {
      this.orderLines = result.orderItems.map((x: OrderItem) => {
        return {
          id: x.id,
          courier_name: x.courier_name,
          tracking_number: x.tracking_number,
          status: !x.status || x.status === '0' ? OrderStatusEnum['Ordered'] : x.status
        }
      })
      this.patchForm(result)
    })
  }

  patchForm(data: any) {
    this.orderStatusForm.patchValue({
      status: data.status,
      tracking_number: data.tracking_number,
      courier_name: data.courier_name
    })
  }

  initializeForm() {
    this.orderStatusForm = this.fb.group({
      status: ['', Validators.required],
      tracking_number: [''],
      courier_name: ['']
    });
  }

  saveOrderForm() {
    const obj: SaveOrder = {
      orderId: this.orderId,
      status: this.orderStatusForm.value.status,
      tracking_number: this.orderStatusForm.value.tracking_number,
      courier_name: this.orderStatusForm.value.courier_name,
    }

    this._store.saveOrderStatus(obj).subscribe(result => {
      this._store.getOrderLogs(obj.orderId).subscribe();
    })
  }

  handleOrderItemForm(event: Event, id: number) {
    const input = event.target as HTMLInputElement

    const el = this.orderLines.find(x => x.id === id)

    el[input.name] = input.value
  }

  handleSaveOrderLineForm(id: number) {
    const el = this.orderLines.find(x => x.id === id)

    this._store.saveOrderLineStatus(el).subscribe(result => {
      this._store.getOrderLogs(this.orderId).subscribe();
    })
  }
}
