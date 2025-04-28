import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {CouponApi} from '../../apis/coupon.api';
import {GlobalStore} from '../global.store';
import {Coupon} from "../../types/coupons/coupon";
import {UiError} from '../../core/services/exception.service';
import {tap} from 'rxjs/operators';


export interface CouponFormState {
}

const defaultState: CouponFormState = {
};

@Injectable()
export class CouponFormStore extends ComponentStore<CouponFormState> {
  constructor(private _api: CouponApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  saveData = (payload: Partial<Coupon>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)

    return request$.pipe(
      tap(() => this.patchState({loading: true})),
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
}
