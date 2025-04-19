import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'


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
  constructor() {
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
  setError(error: string) {
    this.patchState({error: error})
  }

  setSuccess(success: string) {
    this.patchState({success: success})
  }
}
