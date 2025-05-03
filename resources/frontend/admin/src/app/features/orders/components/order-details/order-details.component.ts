import { Component, inject, OnInit, TemplateRef, ViewChild, ViewContainerRef } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { OrderDetailsStore } from '../../../../store/orders/order-details.store';
import { SaveOrder } from '../../../../types/orders/save-order';
import { ActivatedRoute } from '@angular/router';
import { OrderStatusEnum } from '../../../../types/orders/orderStatus.enum';
import { OrderDetail } from '../../../../types/orders/order-detail';
import { OrderItem } from '../../../../types/orders/orderItem';
import { LookupStore } from '../../../../store/lookup.store';
import { Courier } from '../../../../types/couriers/courier';
import { ModalService } from '../../../../services/modal.service';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';

@Component({
  selector: 'app-order-details',
  standalone: false,
  templateUrl: './order-details.component.html',
  styleUrl: './order-details.component.scss',
  providers: [OrderDetailsStore]
})
export class OrderDetailsComponent implements OnInit {

  orderStatusForm: FormGroup;
  modalService: ModalService = inject(ModalService);
  @ViewChild('featureModal', { static: true, read: ViewContainerRef })
  featureModal!: ViewContainerRef;
  @ViewChild('username') input: TemplateRef<any>;
  private _store = inject(OrderDetailsStore)
  vm$ = this._store.vm$
  messages$ = this._store.messages$
  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$
  private fb = inject(FormBuilder)
  private orderId: number;
  private activatedRoute = inject(ActivatedRoute)
  private orderLines: any;
  protected readonly OrderStatusEnum = OrderStatusEnum;
  couriers: Courier[] = []

  ngOnInit(): void {
    this.initializeForm()
    this._lookupStore.getCouriers().subscribe((result: Courier[]) => {
      this.couriers = result
    })

    this.activatedRoute.params.subscribe(params => {
      this.orderId = params['id'];
    })

    this._store.getOrderDetails(this.orderId).subscribe((result: OrderDetail) => {
      this.orderLines = result.orderItems.map((x: OrderItem) => {
        return {
          id: x.id,
          courier_id: x.courier_id,
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
      courier_id: data.courier_id
    })
  }

  initializeForm() {
    this.orderStatusForm = this.fb.group({
      status: ['', Validators.required],
      tracking_number: [''],
      courier_id: ['']
    });
  }

  saveOrderForm() {
    const obj: SaveOrder = {
      orderId: this.orderId,
      status: this.orderStatusForm.value.status,
      tracking_number: this.orderStatusForm.value.tracking_number,
      courier_id: this.orderStatusForm.value.courier_id,
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

  trackCourierItem(orderItemId: number, courierId: number) {
    return `${orderItemId}-${courierId}`
  }

  showMessages(orderItemId: number) {
    this._store.filterMessages(orderItemId)
    this.modalService
      .openConfirmationModal(ModalComponent, this.featureModal, {}, {
        modalTitle: 'Message',
        template: this.input,
        showFooter: false
      })
      .subscribe((v) => {
        //this.form.controls['bump_days'].setValue(this.days);
      });
  }

  getMessages(orderItemId: number) {
    this.orderLines.filter(x => x.id === orderItemId).messages
  }
}
