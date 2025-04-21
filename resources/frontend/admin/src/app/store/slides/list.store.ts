import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Slide} from '../../types/slides/slide';
import {SlideApi} from '../../apis/slide.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface SlideState {
  slides: Slide[];
}

const defaultState: SlideState = {
  slides: [],
};

@Injectable({
  providedIn: 'root'
})
export class SlideStore extends ComponentStore<SlideState> {
  constructor(private _api: SlideApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly slides$ = this.select(({slides}) => slides);

  readonly vm$ = this.select(
    {
      slides: this.slides$,
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
