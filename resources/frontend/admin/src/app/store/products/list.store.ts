import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Product} from '../../types/products/product';
import {ProductApi} from '../../apis/product.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface ProductState {
  products: Product[];
}

const defaultState: ProductState = {
  products: [],
};

@Injectable({
  providedIn: 'root'
})
export class ProductStore extends ComponentStore<ProductState> {
  constructor(private _api: ProductApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly products$ = this.select(({products}) => products);

  readonly vm$ = this.select(
    {
      products: this.products$,
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
