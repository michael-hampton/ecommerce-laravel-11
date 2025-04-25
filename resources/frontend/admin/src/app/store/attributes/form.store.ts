import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {AttributeApi} from '../../apis/attribute.api';
import {GlobalStore} from "../global.store";
import {Attribute} from '../../types/attributes/attribute';
import {UiError} from '../../core/services/exception.service';


export interface AttributeFormState {

}

const defaultState: AttributeFormState = {

};

@Injectable()
export class AttributeFormStore extends ComponentStore<AttributeFormState> {
  constructor(private _service: AttributeApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  saveData = (payload: Partial<Attribute>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._service.update(id, payload) : this._service.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          //this.patchState({loading: false, saveSuccess: false})
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }
}
