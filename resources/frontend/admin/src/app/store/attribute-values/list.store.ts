import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {AttributeValue} from "../../types/attribute-values/attribute-value";
import {AttributeValuesApi} from '../../apis/attribute-values.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface AttributeValueState {
  attributeValues: AttributeValue[];
}

const defaultState: AttributeValueState = {
  attributeValues: [],
};

@Injectable({
  providedIn: 'root'
})
export class AttributeValueStore extends ComponentStore<AttributeValueState> {
  constructor(private _api: AttributeValuesApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly attributeValues$ = this.select(({attributeValues}) => attributeValues);

  readonly vm$ = this.select(
    {
      attributeValues: this.attributeValues$,
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
