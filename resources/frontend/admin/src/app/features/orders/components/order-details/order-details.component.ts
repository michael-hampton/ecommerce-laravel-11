import { Component, inject, OnInit, TemplateRef, ViewChild, ViewContainerRef } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
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
import { RefundModalComponent } from '../refund-modal/refund-modal.component';

@Component({
  selector: 'app-order-details',
  standalone: false,
  templateUrl: './order-details.component.html',
  styleUrl: './order-details.component.scss',
  providers: [OrderDetailsStore]
})
export class OrderDetailsComponent implements OnInit {

  orderStatusForm: FormGroup;
  orderLinesForm: FormGroup;
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
  protected readonly OrderStatusEnum = OrderStatusEnum;
  couriers: Courier[] = []

  ngOnInit(): void {
    this.initializeForm()
    this._lookupStore.getCouriers(undefined).subscribe((result: Courier[]) => {
      this.couriers = result
    })

    this.activatedRoute.params.subscribe(params => {
      this.orderId = params['id'];
    })

    this.orderLinesForm = this.fb.group({
      lines: this.fb.array([]),
    });

    this._store.getOrderDetails(this.orderId).subscribe((result: OrderDetail) => {
      const methodFormArray = this.orderLinesForm.get('lines') as FormArray;

      result.orderItems.forEach(item => {
        const topicFormGroup = this.fb.group({
          id: item.id,
          courier_id: item.courier_id,
          tracking_number: item.tracking_number,
          status: item.status === '0' ? OrderStatusEnum['Ordered'] : item.status
        });
        methodFormArray.push(topicFormGroup);
      })

      this.patchForm(result)
    })
  }

  get formLines(): FormArray {
    return this.orderLinesForm.get('lines') as FormArray
  }

  onStatusChange(event: Event, id: number) {
    const input = event.target as HTMLInputElement

    if (input.value === 'cancelled') {
      this.modalService
        .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: 'Are you sure you want to cancel this item', saveButtonLabel: 'Cancel' })
        .subscribe((v) => {
          //alert('here')
        });
    }
  }

  getMethodControls(orderItemId: number): FormGroup {
    return (this.formLines.controls as FormGroup[]).find(x => x.value.id === orderItemId);
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

  handleSaveOrderLineForm(id: number) {
    const el = this.getMethodControls(id)

    this._store.saveOrderLineStatus(el.value).subscribe(result => {
      this._store.getOrderLogs(this.orderId).subscribe();
    })
  }

  trackCourierItem(orderItemId: number, courierId: number) {
    return `${orderItemId}-${courierId}`
  }

  showMessages(orderItemId: number) {
    this.modalService
      .openModal(RefundModalComponent, { orderItemId: orderItemId }, { modalTitle: 'Issue With Order' })
      .subscribe((v) => {
        this.modalService.closeModal();
      });
  }
}
