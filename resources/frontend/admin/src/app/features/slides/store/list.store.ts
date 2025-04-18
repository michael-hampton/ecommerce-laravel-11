import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {Slide} from '../../../data/slide';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {SlideService} from '../../../service/slide.service';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from '../../../shared/store/global.store';


export interface SlideState {
  slides: Slide[];
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: SlideState = {
  slides: [],
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class SlideStore extends ComponentStore<SlideState> {
  constructor(private _service: SlideService, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly slides$ = this.select(({slides}) => slides);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      slides: this.slides$,
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
