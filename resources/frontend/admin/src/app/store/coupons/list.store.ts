import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, Observable, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Coupon} from '../../types/coupons/coupon';
import {CouponApi} from '../../apis/coupon.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {FilterModel, PagedData} from '../../types/filter.model';
import {Attribute} from '../../types/attributes/attribute';


export interface CouponState {
  data: PagedData<Coupon>;
}

const defaultState: CouponState = {
  data: {} as PagedData<Coupon>,
};

@Injectable({
  providedIn: 'root'
})
export class CouponStore extends ComponentStore<CouponState> {
  constructor(private _api: CouponApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({data}) => data);

  readonly vm$ = this.select(
    {
      data: this.data$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((id) => this._api.delete(id).pipe(
          tapResponse({
            next: (users) => {
              this._globalStore.setSuccess('Deleted successfully');
              //this.patchState({loading: false, saveSuccess: true})
            },
            error: (error: HttpErrorResponse) => {
              this._globalStore.setLoading(false)
              this._globalStore.setError(UiError(error))
            },
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  loadData = this.effect((filter$: Observable<FilterModel>) =>
    filter$.pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((filter: FilterModel) => {
        return this._api.getData(filter).pipe(
          tapResponse({
            next: (data) => {
              alert('hete666')
              this.patchState({data: data as PagedData<Coupon>});
            },
            error: (error: HttpErrorResponse) => {
              this._globalStore.setError(UiError(error));
            },
            finalize: () => this._globalStore.setLoading(false)
          })
        );
      })
    )
  );
}
