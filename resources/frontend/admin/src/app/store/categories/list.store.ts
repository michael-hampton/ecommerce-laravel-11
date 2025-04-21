import {effect, Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, Observable, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Category} from '../../types/categories/category';
import {CategoryApi} from '../../apis/category.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {FilterStore} from '../filter.store';
import {FilterModel, PagedData} from '../../types/filter.model';


export interface CategoryState {
  data: PagedData<Category>;
}

const defaultState: CategoryState = {
  data: {} as PagedData<Category>,
};

@Injectable({
  providedIn: 'root'
})
export class CategoryStore extends FilterStore<CategoryState> {
  constructor(private _api: CategoryApi, private _globalStore: GlobalStore) {
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
                this.patchState({data: data as PagedData<Category>});
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


  /* loadData = () => {
  eturn this._api.getData().pipe(
     map(response =>
       response.data ? response.data : []
     ),
     catchError((error: HttpErrorResponse) => {
       this._globalStore.setError(UiError(error))
       return throwError(() => error)
     })
   )
 }*/
}
