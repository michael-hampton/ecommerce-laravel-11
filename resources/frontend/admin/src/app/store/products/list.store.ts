import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {Observable, pipe, switchMap, tap} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Product} from '../../types/products/product';
import {ProductApi} from '../../apis/product.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {defaultPaging, FilterModel, FilterState, PagedData} from '../../types/filter.model';
import {FilterStore} from '../filter.store';

const defaultState: FilterState<Product> = {
  data: {} as PagedData<Product>,
  filter: {...defaultPaging, ...{sortBy: 'name'}}
};

@Injectable()
export class ProductStore extends FilterStore<Product> {
  constructor(private _api: ProductApi, private _globalStore: GlobalStore) {
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
            error: (error: HttpErrorResponse) =>  this._globalStore.setError(UiError(error)),
            finalize: () => this._globalStore.setLoading(false),
          })
        )
      )
    )
  );

  makeActive(id: number) {
    return this._api.toggleActive(id).pipe(
      tapResponse({
        next: (data) => this._globalStore.setSuccess('Saved successfully'),
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
            next: (data) => {
              this.patchState({data: data as PagedData<Product>})
            },
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            complete: () => {
              this._globalStore.setLoading(false)
            }
          })
        )
      )
    )
  );
}
