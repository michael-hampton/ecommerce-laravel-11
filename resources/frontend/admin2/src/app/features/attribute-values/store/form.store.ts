import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from '../../../shared/store/global.store';
import {AttributeValuesService} from '../../../service/attribute-values.service';
import {AttributeValue} from '../../../data/attribute-value';


export interface AttributeValueFormState {
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: AttributeValueFormState = {
  loading: false,
  error: '',
  saveSuccess: false,
};

@Injectable({
  providedIn: 'root'
})
export class AttributeValueFormStore extends ComponentStore<AttributeValueFormState> {
  constructor(private _service: AttributeValuesService, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  vm$ = this.select(state => ({
    loading: state.loading,
    error: state.error,
  }))

  saveData = (payload: Partial<AttributeValue>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._service.update(id, payload) : this._service.create(dataCreate)
    this.patchState({loading: true})

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this.patchState({loading: false, saveSuccess: false})
          this._globalStore.setError(error.message)
        },
        finalize: () => this.patchState({loading: false}),
      })
    )
  }
}
