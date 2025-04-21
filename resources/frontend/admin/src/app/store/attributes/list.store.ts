import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {Attribute} from '../../types/attributes/attribute';
import {GlobalStore} from "../global.store";
import {AttributeApi} from '../../apis/attribute.api';
import {UiError} from '../../core/services/exception.service';


export interface AttributeState {
  attributes: Attribute[];
}

const defaultState: AttributeState = {
  attributes: [],
};

@Injectable({
  providedIn: 'root'
})
export class AttributeStore extends ComponentStore<AttributeState> {
  constructor(private _service: AttributeApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly attributes$ = this.select(({attributes}) => attributes);

  readonly vm$ = this.select(
    {
      attributes: this.attributes$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((id) => this._service.delete(id).pipe(
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
    return this._service.getData().pipe(
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
