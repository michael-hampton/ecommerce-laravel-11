import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {ShippingApi} from '../../apis/shipping.api';
import {GlobalStore} from '../global.store';
import {Shipping} from "../../types/shipping/shipping";
import {UiError} from '../../core/services/exception.service';
import {tap} from 'rxjs/operators';
import {switchMap} from 'rxjs';
import {Courier} from '../../types/couriers/courier';
import {AccountDetails} from '../../types/seller/account-details';


export interface ShippingFormState {
  couriers: Courier[],
  loading: boolean,
  shippings: Shipping[]
}

const defaultState: ShippingFormState = {
  couriers: [],
  loading: false,
  shippings: []
};

@Injectable()
export class ShippingFormStore extends ComponentStore<ShippingFormState> {
  constructor(private _api: ShippingApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    couriers: state.couriers,
  }))

  saveData = (payload: any) => {

    return this._api.create(payload).pipe(
      tap(() =>  this.patchState({loading: true})),
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  readonly getCouriers = this.effect<void>(
    // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good
    // names. We encourage to choose one of these and use them consistently in your codebase.
    (trigger$) => trigger$.pipe(
      switchMap(() =>
        this._api.getCouriers().pipe(
          tapResponse({
            next: (data) => this.patchState({couriers: data.data as Courier[]}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  loadDataForCountry(countryId: number) {
    return this._api.getDataForCountry(countryId).pipe(
      tapResponse({
        next: (data) => this.patchState({shippings: data as Shipping[]}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }
}
