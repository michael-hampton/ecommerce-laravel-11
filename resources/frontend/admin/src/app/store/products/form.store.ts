import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {ProductApi} from '../../apis/product.api';
import {GlobalStore} from '../global.store';
import {Product} from "../../types/products/product";
import {UiError} from '../../core/services/exception.service';

export interface ProductFormState {
  loading: boolean;
  error: string;
  saveSuccess: boolean;
  imagePreview: string;
  currentFile?: File;
}

const defaultState: ProductFormState = {
  loading: false,
  error: '',
  saveSuccess: false,
  imagePreview: '',
  currentFile: undefined
};

@Injectable({
  providedIn: 'root'
})
export class ProductFormStore extends ComponentStore<ProductFormState> {
  constructor(private _api: ProductApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  vm$ = this.select(state => ({
    loading: state.loading,
    error: state.error,
    imagePreview: state.imagePreview,
  }))

  saveData = (payload: Partial<Product>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this.patchState({loading: true})

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this.patchState({loading: false, saveSuccess: false})
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this.patchState({loading: false}),
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
}
