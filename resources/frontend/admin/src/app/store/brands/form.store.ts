import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { BrandApi } from '../../apis/brand.api';
import { GlobalStore } from "../global.store";
import { Brand } from "../../types/brands/brand";
import { UiError } from '../../core/services/exception.service';

export interface BrandFormState {
  currentFile?: File;
}

const defaultState: BrandFormState = {
  currentFile: undefined
};

@Injectable()
export class BrandFormStore extends ComponentStore<BrandFormState> {
  constructor(private _api: BrandApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);

  saveData = (payload: Partial<Brand>) => {
    const { id, ...dataCreate } = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => this._globalStore.setSuccess('Saved successfully'),
        error: (error: HttpErrorResponse) => {
          //this.patchState({loading: false, saveSuccess: false})
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  readonly addImage = this.updater((state, currentFile: File) => ({
    ...state,
    currentFile: currentFile
  }));

  readonly addImages = this.updater((state, selectedFiles: FileList) => ({
    ...state,
    selectedFiles: selectedFiles
  }));

}
