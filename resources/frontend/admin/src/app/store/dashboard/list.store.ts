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
import {UiError} from '../../core/services/exception.service';


export interface DashboardState {
  data: Dashboard;
}

const defaultState: DashboardState = {
  data: {} as Dashboard,
};

@Injectable({
  providedIn: 'root'
})
export class DashboardStore extends ComponentStore<DashboardState> {
  constructor(private _api: DashboardApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({data}) => data);

  readonly vm$ = this.select(
    {
      data: this.data$,
    },
    {debounce: true}
  );

  getData = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
    pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap(filter =>
        this._api.getData().pipe(
          tapResponse({
            next: (data) => this.patchState({data: data.data}),
            error: (error: HttpErrorResponse) => {
              this._globalStore.setLoading(false)
              this._globalStore.setError(UiError(error))
            },
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    ));
}
