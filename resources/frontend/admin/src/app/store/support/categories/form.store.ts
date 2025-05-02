import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import { GlobalStore } from '../../global.store';
import { UiError } from '../../../core/error.model';
import { Category } from '../../../types/support/category';
import { SupportCategoryApi } from '../../../apis/support-category.api';


export interface SupportCategoryFormState {

}

const defaultState: SupportCategoryFormState = {

};

@Injectable()
export class SupportCategoryFormStore extends ComponentStore<SupportCategoryFormState> {
  constructor(private _api: SupportCategoryApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  saveData = (payload: Partial<Category>) => {
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
