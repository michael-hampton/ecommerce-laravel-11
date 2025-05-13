import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { GlobalStore } from '../global.store';
import { UiError } from '../../core/services/exception.service';
import { tap } from 'rxjs/operators';
import { of, pipe, switchMap } from 'rxjs';
import { Courier } from '../../types/couriers/courier';
import { Country } from '../../types/countries/country';
import { CourierApi } from '../../apis/courier.api';


export interface CourierFormState {
  loading: boolean,
  couriers: Courier[],
  countries: Country[]
}

const defaultState: CourierFormState = {
  couriers: [],
  loading: false,
  countries: [],
};

@Injectable()
export class CourierFormStore extends ComponentStore<CourierFormState> {
  constructor(private _api: CourierApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    couriers: state.couriers,
    countries: state.countries,
    loading: state.loading
  }))

  saveData = (payload: Partial<Courier>) => {
      const {id, ...dataCreate} = payload
      const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
      this._globalStore.setLoading(true)
  
      return request$.pipe(
        tapResponse({
          next: (users) => this._globalStore.setSuccess('Saved successfully'),
          error: (error: HttpErrorResponse) => {
            //this.patchState({loading: false, saveSuccess: false})
            this._globalStore.setLoading(false)
            this._globalStore.setError(UiError(error))
          },
          finalize: () => this._globalStore.setLoading(false),
        })
      )
    }

  readonly getCountries = this.effect<boolean>(
    pipe(
      switchMap((filter) =>
        this._api.getCountries().pipe(
          tapResponse({
            next: (data) => {
              this.patchState({ countries: filter === true ? (data as Country[]).filter(x => x.shipping_active === true) : data as Country[] })
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
        next: (data) => this.patchState({ couriers: data as Courier[] }),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({ loading: false }),
      })
    )
  }
}
