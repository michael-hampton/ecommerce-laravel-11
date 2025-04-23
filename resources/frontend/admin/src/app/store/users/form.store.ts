import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {User} from "../../types/users/user";
import {UserApi} from '../../apis/user.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface UserFormState {
  imagePreview: string;
  currentFile?: File;
}

const defaultState: UserFormState = {
  imagePreview: '',
  currentFile: undefined
};

@Injectable({
  providedIn: 'root'
})
export class UserFormStore extends ComponentStore<UserFormState> {
  constructor(private _api: UserApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);
  readonly image$ = this.select(({imagePreview}) => imagePreview);

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
  }))

  saveData = (payload: Partial<User>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  selectFile(event: any): void {
    this.patchState({imagePreview: ''})
    const selectedFiles = event.target.files;

    if (selectedFiles) {
      const file: File | null = selectedFiles.item(0);

      if (file) {
        this.patchState({imagePreview: '', currentFile: file})

        const reader = new FileReader();

        reader.onload = (e: any) => {
          this.patchState({imagePreview: e.target.result})

        };

        reader.readAsDataURL(file);
      }
    }
  }

  readonly addImage = this.updater((state, imagePreview: string) => ({
    imagePreview: imagePreview,
  }));
}
