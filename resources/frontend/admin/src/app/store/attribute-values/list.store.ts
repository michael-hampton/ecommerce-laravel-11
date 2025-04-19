import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {AttributeValue} from "../../types/attribute-values/attribute-value";
import {AttributeValuesApi} from '../../apis/attribute-values.api';
import {GlobalStore} from "../global.store";


export interface AttributeValueState {
  attributeValues: AttributeValue[];
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: AttributeValueState = {
  attributeValues: [],
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class AttributeValueStore extends ComponentStore<AttributeValueState> {
  constructor(private _api: AttributeValuesApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly attributeValues$ = this.select(({attributeValues}) => attributeValues);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      attributeValues: this.attributeValues$,
      loading: this.loading$,
      error: this.error$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap((id) => this._api.delete(id).pipe(
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
    return this._api.getData().pipe(
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
