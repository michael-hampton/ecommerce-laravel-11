import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { ShippingApi } from '../../apis/shipping.api';
import { GlobalStore } from '../global.store';
import { Shipping } from "../../types/shipping/shipping";
import { UiError } from '../../core/services/exception.service';
import { tap } from 'rxjs/operators';
import { of, pipe, switchMap } from 'rxjs';
import { Courier } from '../../types/couriers/courier';
import { Country } from '../../types/countries/country';


export interface ShippingFormState {
  couriers: Courier[],
  loading: boolean,
  shippings: Shipping[]
  countries: Country[]
}

const defaultState: ShippingFormState = {
  couriers: [],
  loading: false,
  shippings: [],
  countries: []
};

@Injectable()
export class ShippingFormStore extends ComponentStore<ShippingFormState> {
  constructor(private _api: ShippingApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    couriers: state.couriers,
    countries: state.countries,
    loading: state.loading
  }))

  saveData = (payload: any, id: number) => {

    return id ? this._api.update(id, payload) : this._api.create(payload).pipe(
      tap(() => this.patchState({ loading: true })),
      tapResponse({
        next: (users) => this._globalStore.setSuccess('Saved successfully'),
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this.patchState({ loading: false }),
      })
    )
  }

  readonly getCountries = this.effect<boolean>(
    pipe(
      switchMap((filter) =>
        this._api.getCountries().pipe(
          tapResponse({
            next: (data) => {
              this.patchState({ countries: filter === true ? (data as Country[]).filter(x => x.shipping_active === false) : data as Country[] })
            },
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  readonly getCouriers = this.effect<void>(
    (trigger$) => trigger$.pipe(
      switchMap(() =>
        this._api.getCouriers().pipe(
          tapResponse({
            next: (data) => this.patchState({ couriers: data as Courier[] }),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  loadDataForCountry(countryId: number) {
    this.patchState({ loading: true })
    return this._api.getDataForCountry(countryId).pipe(
      tap(() => this.patchState({ loading: true })),
      tapResponse({
        next: (data) => this.patchState({ shippings: data as Shipping[] }),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({ loading: false }),
      })
    )
  }
}
