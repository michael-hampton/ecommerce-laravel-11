import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from '../../../shared/store/global.store';
import {BrandService} from '../../../service/brand.service';
import {Brand} from '../../../data/brand';


export interface BrandFormState {
  loading: boolean;
  error: string;
  saveSuccess: boolean;
  imagePreview: string;
  currentFile?: File;
}

const defaultState: BrandFormState = {
  loading: false,
  error: '',
  saveSuccess: false,
  imagePreview: '',
  currentFile: undefined
};

@Injectable({
  providedIn: 'root'
})
export class BrandFormStore extends ComponentStore<BrandFormState> {
  constructor(private _service: BrandService, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  vm$ = this.select(state => ({
    loading: state.loading,
    error: state.error,
    imagePreview: state.imagePreview,
  }))

  saveData = (payload: Partial<Brand>) => {
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
