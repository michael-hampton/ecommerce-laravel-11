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
import { LookupApi } from '../../apis/lookup.api';


export interface ShippingFormState {
  allCouriers: Courier[],
  filteredCouriers: Courier[],
  loading: boolean,
  shippings: Shipping[]
  countries: Country[]
}

const defaultState: ShippingFormState = {
  allCouriers: [],
  filteredCouriers: [],
  loading: false,
  shippings: [],
  countries: []
};

@Injectable()
export class ShippingFormStore extends ComponentStore<ShippingFormState> {
  constructor(private _api: ShippingApi, private _lookupApi: LookupApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    couriers: state.filteredCouriers,
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

  readonly getCouriers = this.effect<number>(
    (countryId$) => countryId$.pipe(
      switchMap((countryId) =>
        this._lookupApi.getCouriers(countryId).pipe(
          tapResponse({
            next: (data) => this.patchState({ allCouriers: data as Courier[], filteredCouriers: data as Courier[] }),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  readonly filterCouriers = this.updater((state, countryId: number) => ({
    ...state,
    filteredCouriers: state.allCouriers.find(x => x.country_id === countryId) ? state.allCouriers.filter(courier =>
      courier.country_id === countryId
    ) : state.allCouriers
  }));

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
