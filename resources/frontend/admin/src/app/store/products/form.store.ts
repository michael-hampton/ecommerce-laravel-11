import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {ProductApi} from '../../apis/product.api';
import {GlobalStore} from '../global.store';
import {Product} from "../../types/products/product";
import {UiError} from '../../core/services/exception.service';
import {switchMap, tap} from 'rxjs';
import {Category} from '../../types/categories/category';
import {LookupApi} from '../../apis/lookup.api';

export interface ProductFormState {
  imagePreview: string;
  currentFile?: File;
  subcategories: Category[],
  grandchildren: Category[]
}

const defaultState: ProductFormState = {
  imagePreview: '',
  currentFile: undefined,
  subcategories: [],
  grandchildren: []
};

@Injectable({
  providedIn: 'root'
})
export class ProductFormStore extends ComponentStore<ProductFormState> {
  constructor(private _api: ProductApi, private _globalStore: GlobalStore, private _lookupService: LookupApi) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);
  readonly image$ = this.select(({imagePreview}) => imagePreview);

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
  }))

  saveData = (payload: Partial<Product>) => {
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

  readonly getSubcategories = this.effect<number>((categoryId) => {
    return categoryId.pipe(
      switchMap(categoryId =>
        this._lookupService.getSubcategories(categoryId).pipe(
          tapResponse({
            next: (subcategories) => this.patchState({ subcategories: subcategories as Category[] }),
            error: (error: HttpErrorResponse) => {
              this._globalStore.setError(UiError(error))
            },
          })
        )
      )
    );
  });

  readonly getGrandChildrenCategories = this.effect<number>((categoryId) => {
    return categoryId.pipe(
      switchMap(categoryId =>
        this._lookupService.getSubcategories(categoryId).pipe(
          tapResponse({
            next: (subcategories) => this.patchState({ grandchildren: subcategories as Category[] }),
            error: (error: HttpErrorResponse) => {
              this._globalStore.setError(UiError(error))
            },
          })
        )
      )
    );
  });

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

  updateImagePreview(imagePreview: string) {
    this.patchState({imagePreview: imagePreview})
  }
}
