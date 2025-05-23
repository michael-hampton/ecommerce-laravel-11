import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { ProductApi } from '../../apis/product.api';
import { GlobalStore } from '../global.store';
import { Product } from "../../types/products/product";
import { UiError } from '../../core/services/exception.service';
import { switchMap, tap } from 'rxjs';
import { Category } from '../../types/categories/category';
import { LookupApi } from '../../apis/lookup.api';

export interface ProductFormState {
  currentFile?: File;
  subcategories: Category[],
  grandchildren: Category[],
  selectedFiles?: FileList;
  previews?: string[];
}

const defaultState: ProductFormState = {
  currentFile: undefined,
  subcategories: [],
  grandchildren: [],
  previews: []

};

@Injectable()
export class ProductFormStore extends ComponentStore<ProductFormState> {
  constructor(private _api: ProductApi, private _globalStore: GlobalStore, private _lookupService: LookupApi) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);
  readonly files$ = this.select(state => state.selectedFiles);
  readonly galleryImages$ = this.select(({ previews }) => previews);

  vm$ = this.select(state => ({
    selectedFiles: state.selectedFiles
  }))

  saveData = (payload: Partial<Product>) => {
    const { id, ...dataCreate } = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => this._globalStore.setSuccess('Saved successfully'),
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  bumpProduct = (payload: any, productId: number) => {
    this._globalStore.setLoading(true)

    return this._api.bumpProduct(payload, productId).pipe(
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

  readonly addImage = this.updater((state, currentFile: File) => ({
    ...state,
    currentFile: currentFile
  }));

  readonly addImages = this.updater((state, selectedFiles: FileList) => ({
    ...state,
    selectedFiles: selectedFiles
  }));
}
