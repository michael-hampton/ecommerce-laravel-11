import { effect, Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { catchError, map, Observable, pipe, switchMap, tap, throwError } from 'rxjs';
import { tapResponse } from '@ngrx/operators'
import { Category } from '../../types/categories/category';
import { CategoryApi } from '../../apis/category.api';
import { GlobalStore } from "../global.store";
import { UiError } from '../../core/services/exception.service';
import { FilterStore } from '../filter.store';
import { defaultPaging, FilterModel, FilterState, PagedData } from '../../types/filter.model';

const defaultState: FilterState<Category> = {
  data: {} as PagedData<Category>,
  filter: { ...defaultPaging, ...{ sortBy: 'name' } }
};

@Injectable()
export class CategoryStore extends FilterStore<Category> {
  constructor(private _api: CategoryApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({ data }) => data);

  readonly vm$ = this.select(
    {
      data: this.data$,
      filter: this.filter$
    },
    { debounce: true }
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((id) => this._api.delete(id).pipe(
        tapResponse({
          next: (users) => this._globalStore.setSuccess('Deleted successfully'),
          error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
          finalize: () => this._globalStore.setLoading(false),
        })
      )
      )
    )
  );

  makeActive(updatedCategory: Category) {
    return this._api.toggleActive(updatedCategory.id).pipe(
      tapResponse({
        next: (data) => {
          updatedCategory.active = updatedCategory.active ? 0 : 1
          this.patchState((state) => ({
            data: {...state.data, ...{data: state.data.data.map(category => 
              category.id === updatedCategory.id ? updatedCategory : category
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
          next: (data) => this.patchState({ data: data as PagedData<Category> }),
          error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
          complete: () => this._globalStore.setLoading(false)
        })
      )
      )
    )
  );
}
