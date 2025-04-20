import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import {IUiError} from '../core/services/exception.service';
import {Toast} from '../services/toast/toast.service';


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
  constructor(private toast: Toast) {
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
    this.toast.ShowError('hello world');
    this.patchState({error: error.message})
  }

  setSuccess(success: string) {
    this.toast.ShowSuccess('hello world');
    this.patchState({success: success})
  }
}
