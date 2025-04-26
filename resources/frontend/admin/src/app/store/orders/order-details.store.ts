import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {OrderApi} from '../../apis/order.api';
import {SaveOrder, SaveOrderLine} from '../../types/orders/save-order';
import {OrderDetail} from '../../types/orders/order-detail';
import {OrderLog} from '../../types/orders/orderLog';
import {tap} from 'rxjs/operators';
import {Courier} from '../../types/couriers/courier';
import {pipe, switchMap} from 'rxjs';
import {Category} from '../../types/categories/category';

export interface OrderDetailsState {
  order: OrderDetail;
  orderLogs: OrderLog[],
  loading: boolean
  orderUpdated: boolean
  orderLineUpdated: boolean
}

const defaultState: OrderDetailsState = {
  order: {} as OrderDetail,
  orderLogs: [],
  loading: false,
  orderUpdated: false,
  orderLineUpdated: false,
};

@Injectable()
export class OrderDetailsStore extends ComponentStore<OrderDetailsState> {
  constructor(private _api: OrderApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }


  vm$ = this.select(state => ({
    order: state.order,
    orderLogs: state.orderLogs,
    loading: state.loading,
    orderUpdated: state.orderUpdated,
    orderLineUpdated: state.orderLineUpdated,
  }))

  saveOrderStatus = (payload: Partial<SaveOrder>) => {
    this.patchState({loading: true})

    return this._api.update(payload.orderId, payload).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: () => this.showOrderSuccess(),
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  saveOrderLineStatus = (payload: Partial<SaveOrderLine>) => {

    return this._api.saveOrderDetailStatus(payload.id, payload).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: () => this.showOrderLineSuccess(),
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  getOrderDetails(orderId: number) {
    return this._api.getOrderDetails(orderId).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: (order: OrderDetail) => {
          let orderLogs: OrderLog[] = order.orderItems.map(x => x.orderLogs)[0]
          orderLogs = orderLogs.concat(order.orderLogs)
          this.patchState({order: order as OrderDetail, orderLogs: orderLogs})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  getOrderLogs(orderId: number) {
    return this._api.getOrderLogs(orderId).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: (orderLogs: OrderLog[]) => {
          console.log('new logs', orderLogs)
          this.patchState({orderLogs: orderLogs})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  showOrderLineSuccess() {
    this.patchState({orderLineUpdated: true})

    setTimeout(() => {
      this.patchState({orderLineUpdated: false})
    }, 2500);
  }

  showOrderSuccess() {
    this.patchState({orderUpdated: true})

    setTimeout(() => {
      this.patchState({orderUpdated: false})
    }, 2500);
  }
}
