import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { SlideApi } from '../../apis/slide.api';
import { GlobalStore } from "../global.store";
import { Slide } from "../../types/slides/slide";
import { UiError } from '../../core/services/exception.service';


export interface SlideFormState {
  currentFile?: File;
}

const defaultState: SlideFormState = {
  currentFile: undefined
};

@Injectable()
export class SlideFormStore extends ComponentStore<SlideFormState> {
  constructor(private _api: SlideApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);

  saveData = (payload: Partial<Slide>) => {
    const { id, ...dataCreate } = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
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

  readonly addImage = this.updater((state, currentFile: File) => ({
    ...state,
    currentFile: currentFile
  }));

  readonly addImages = this.updater((state, selectedFiles: FileList) => ({
    ...state,
    selectedFiles: selectedFiles
  }));
}
