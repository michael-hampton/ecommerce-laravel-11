import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Product} from '../../types/products/product';
import {ProductApi} from '../../apis/product.api';
import {GlobalStore} from "../global.store";
import {Dashboard} from '../../types/dashboard/dashboard';
import {DashboardApi} from '../../apis/dashboard.api';


export interface DashboardState {
  data: Dashboard;
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: DashboardState = {
  data: {} as Dashboard,
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class DashboardStore extends ComponentStore<DashboardState> {
  constructor(private _api: DashboardApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({data}) => data);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      data: this.data$,
      loading: this.loading$,
      error: this.error$,
    },
    {debounce: true}
  );

  getData = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._api.getData().pipe(
          tapResponse({
            next: (data) => this.patchState({data: data.data}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(error.message),
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    ));
}
