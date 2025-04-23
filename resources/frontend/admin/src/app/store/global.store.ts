import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import {IUiError} from '../core/services/exception.service';
import {Toast} from '../services/toast/toast.service';
import {LoaderService} from '../services/loader/loader.service';


export interface GlobalState {
  loading: boolean;
  error: string;
  success: string
}

const defaultState: GlobalState = {
  loading: false,
  error: '',
  success: ''
};

@Injectable({
  providedIn: 'root'
})
export class GlobalStore extends ComponentStore<GlobalState> {
  constructor(private toast: Toast, private loader: LoaderService) {
    super(defaultState);
  }

  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);
  private readonly success$ = this.select((state) => state.success);


  readonly vm$ = this.select(
    {
      loading: this.loading$,
      error: this.error$,
      success: this.success$,
    },
    { debounce: true }
  );
  setError(error: IUiError) {
    this.toast.ShowError(error.code, {}, error.message);
    this.setLoading(false)
    this.patchState({error: error.message})
  }

  setLoading(loading: boolean) {
    this.patchState({loading: loading})
    if(loading) {
      return this.loader.show();
    }

    return this.loader.hide();
  }

  setSuccess(success: string) {
    this.toast.ShowSuccess(null, {}, success);
    this.patchState({success: success})
  }
}
