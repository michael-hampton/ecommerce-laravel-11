import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {AttributeValuesApi} from '../../apis/attribute-values.api';
import {GlobalStore} from "../global.store";
import {AttributeValue} from "../../types/attribute-values/attribute-value";
import {UiError} from '../../core/services/exception.service';


export interface AttributeValueFormState {

}

const defaultState: AttributeValueFormState = {

};

@Injectable({
  providedIn: 'root'
})
export class AttributeValueFormStore extends ComponentStore<AttributeValueFormState> {
  constructor(private _api: AttributeValuesApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  saveData = (payload: Partial<AttributeValue>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this._globalStore.setLoading(false)
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }
}
