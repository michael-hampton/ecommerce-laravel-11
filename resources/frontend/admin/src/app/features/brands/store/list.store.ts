import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {Brand} from '../../../data/brand';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {BrandService} from '../../../service/brand.service';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from '../../../shared/store/global.store';


export interface BrandState {
  brands: Brand[];
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: BrandState = {
  brands: [],
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class BrandStore extends ComponentStore<BrandState> {
  constructor(private _service: BrandService, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly brands$ = this.select(({brands}) => brands);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      brands: this.brands$,
      loading: this.loading$,
      error: this.error$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap((id) => this._service.delete(id).pipe(
          tapResponse({
            next: (users) => {
              this._globalStore.setSuccess('Deleted successfully');
              this.patchState({loading: false, saveSuccess: true})
            },
            error: (error: HttpErrorResponse) => {
              this.patchState({loading: false, saveSuccess: false})
              this._globalStore.setError(error.message)
            },
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  );

  loadData = () => {
    return this._service.getData().pipe(
      map(response =>
        response.data ? response.data : []
      ),
      catchError((error: HttpErrorResponse) => {
        this._globalStore.setError(error.message)
        return throwError(() => error)
      })
    )
  }
}
