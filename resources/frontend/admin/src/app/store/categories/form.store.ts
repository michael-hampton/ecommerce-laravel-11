import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {CategoryApi} from '../../apis/category.api';
import {GlobalStore} from '../global.store';
import {Category} from '../../types/categories/category';
import {UiError} from '../../core/services/exception.service';


export interface CategoryFormState {
  imagePreview: string;
  currentFile?: File;
}

const defaultState: CategoryFormState = {
  imagePreview: '',
  currentFile: undefined
};

@Injectable({
  providedIn: 'root'
})
export class CategoryFormStore extends ComponentStore<CategoryFormState> {
  constructor(private _api: CategoryApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly image$ = this.select(({imagePreview}) => imagePreview);

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
  }))

  saveData = (payload: Partial<Category>) => {
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
          //this.patchState({loading: false, saveSuccess: false})
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
