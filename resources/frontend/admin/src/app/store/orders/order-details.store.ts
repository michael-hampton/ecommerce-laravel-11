import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {OrderApi} from '../../apis/order.api';
import {SaveOrder, SaveOrderLine} from '../../types/orders/save-order';
import {OrderDetail} from '../../types/orders/order-detail';

export interface OrderDetailsState {
  order: OrderDetail;
}

const defaultState: OrderDetailsState = {
  order: {} as OrderDetail,
};

@Injectable({
  providedIn: 'root'
})
export class OrderDetailsStore extends ComponentStore<OrderDetailsState> {
  constructor(private _api: OrderApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }


  vm$ = this.select(state => ({
    order: state.order,
  }))

  saveOrderStatus = (payload: Partial<SaveOrder>) => {
    this._globalStore.setLoading(true)

    return this._api.update(payload.orderId, payload).pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this._globalStore.setLoading(false),
      })
    )
  }

  saveOrderLineStatus = (payload: Partial<SaveOrderLine>) => {
    this._globalStore.setLoading(true)

    return this._api.saveOrderDetailStatus(payload.id, payload).pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getOrderDetails(orderId: number) {
    return this._api.getOrderDetails(orderId).pipe(
      tapResponse({
        next: (order) => this.patchState({order: order as OrderDetail}),
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
      })
    )
  }
}
