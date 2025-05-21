import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {catchError, map, Observable, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import { defaultPaging, FilterModel, FilterState, PagedData } from '../../../types/filter.model';
import { FilterStore } from '../../filter.store';
import { GlobalStore } from '../../global.store';
import { UiError } from '../../../core/error.model';
import { Category } from '../../../types/support/category';
import { SupportCategoryApi } from '../../../apis/support-category.api';

const defaultState: FilterState<Category> = {
  data: {} as PagedData<Category>,
  filter: {...defaultPaging, ...{sortBy: 'name'}}
};

@Injectable()
export class SupportCategoryStore extends FilterStore<Category> {
  constructor(private _api: SupportCategoryApi, private _globalStore: GlobalStore) {
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

  loadData = this.effect((filter$: Observable<FilterModel>) =>
    filter$.pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((filter: FilterModel) => this._api.search(filter).pipe(
          tapResponse({
            next: (data) => this.patchState({data: data as PagedData<Category>}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            complete: () => this._globalStore.setLoading(false)
          })
        )
      )
    )
  );
}
