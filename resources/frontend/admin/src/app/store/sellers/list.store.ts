import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {catchError, map, Observable, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {defaultPaging, FilterModel, FilterState, PagedData} from '../../types/filter.model';
import {FilterStore} from '../filter.store';
import {Seller} from '../../types/seller/seller';
import {SellerApi} from '../../apis/seller.api';
import {Transaction} from '../../types/orders/transaction';

const defaultState: FilterState<Seller> = {
  data: {} as PagedData<Seller>,
  filter: {...defaultPaging, ...{sortBy: 'name'}}
};

@Injectable()
export class SellerStore extends FilterStore<Seller> {
  constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({data}) => data);

  readonly vm$ = this.select(
    {
      data: this.data$,
      filter: this.filter$
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

  makeActive(active: boolean, updatedSeller: Seller) {
      return this._api.toggleActive(updatedSeller.id, active).pipe(
        tapResponse({
          next: (data) => {
            updatedSeller.active = updatedSeller.active ? false : true
            this.patchState((state) => ({
              data: {...state.data, ...{data: state.data.data.map(seller => 
                seller.id === updatedSeller.id ? updatedSeller : seller
              )}}
            }));
            this._globalStore.setSuccess('Saved successfully')
          },
          error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
          finalize: () => this._globalStore.setLoading(false),
        })
      )
    }

  loadData = this.effect((filter$: Observable<FilterModel>) =>
    filter$.pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((filter: FilterModel) => this._api.getData(filter).pipe(
          tapResponse({
            next: (data) => this.patchState({data: data as PagedData<Seller>}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            complete: () => this._globalStore.setLoading(false)
          })
        )
      )
    )
  );
}
