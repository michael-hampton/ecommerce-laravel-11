import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {Seller} from '../../types/seller/seller';
import {SellerApi} from '../../apis/seller.api';
import {UiError} from '../../core/services/exception.service';

export interface ProfileFormState {
  loading: boolean;
  error: string;
  saveSuccess: boolean;
  imagePreview: string;
  currentFile?: File;
  data: Seller
}

const defaultState: ProfileFormState = {
  loading: false,
  error: '',
  saveSuccess: false,
  imagePreview: '',
  currentFile: undefined,
  data: {} as Seller
};

@Injectable({
  providedIn: 'root'
})
export class ProfileStore extends ComponentStore<ProfileFormState> {
  constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  vm$ = this.select(state => ({
    loading: state.loading,
    error: state.error,
    imagePreview: state.imagePreview,
    data: state.data
  }))

  saveData = (payload: Partial<Seller>) => {
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

  getData(sellerId: number) {
    return this._api.getSeller(sellerId).pipe(
      tapResponse({
        next: (data) => this.patchState({data: data.data}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({loading: false}),
      })
    )
  }
}
