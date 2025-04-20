import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Coupon} from '../../types/coupons/coupon';
import {CouponApi} from '../../apis/coupon.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface CouponState {
  coupons: Coupon[];
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: CouponState = {
  coupons: [],
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class CouponStore extends ComponentStore<CouponState> {
  constructor(private _api: CouponApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly coupons$ = this.select(({coupons}) => coupons);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      coupons: this.coupons$,
      loading: this.loading$,
      error: this.error$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap((id) => this._api.delete(id).pipe(
          tapResponse({
            next: (users) => {
              this._globalStore.setSuccess('Deleted successfully');
              this.patchState({loading: false, saveSuccess: true})
            },
            error: (error: HttpErrorResponse) => {
              this.patchState({loading: false, saveSuccess: false})
              this._globalStore.setError(UiError(error))
            },
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  );

  loadData = () => {
    return this._api.getData().pipe(
      map(response =>
        response.data ? response.data : []
      ),
      catchError((error: HttpErrorResponse) => {
        this._globalStore.setError(UiError(error))
        return throwError(() => error)
      })
    )
  }
}
