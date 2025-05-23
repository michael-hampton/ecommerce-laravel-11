import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { CategoryApi } from '../../apis/category.api';
import { GlobalStore } from '../global.store';
import { Category } from '../../types/categories/category';
import { UiError } from '../../core/services/exception.service';
import { pipe, switchMap, tap } from 'rxjs';
import { LookupApi } from '../../apis/lookup.api';


export interface CategoryFormState {
  currentFile?: File;
  categories?: Category[],
  children?: Record<number, Category[]>
}

const defaultState: CategoryFormState = {
  currentFile: undefined,
  categories: [],
  children: []
};

@Injectable()
export class CategoryFormStore extends ComponentStore<CategoryFormState> {
  constructor(private _api: CategoryApi, private _globalStore: GlobalStore, private _lookupService: LookupApi) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);
  readonly children$ = this.select(({ children }) => children);

  vm$ = this.select(state => ({
    categories: state.categories,
    children: state.children
  }))

  saveData = (payload: Partial<Category>) => {
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

  getCategories = this.effect<void>(
    pipe(
      //tap(() => this.patchState({loading: true})),
      switchMap(filter =>
        this._lookupService.getCategories().pipe(
          tapResponse({
            next: (categories: Category[]) => {
              const parents: Category[] = categories.filter(x => x.parent_id === null || x.parent_id === 0)
              const children: Category[] = categories.filter(x => x.parent_id !== null && x.parent_id !== 0)

              const formattedChildren = []

              children.forEach((cat) => {
                if (!formattedChildren[cat.parent_id]) {
                  formattedChildren[cat.parent_id] = []
                }
                formattedChildren[cat.parent_id].push(cat)
              })

              console.log('formattedChildren', formattedChildren)

              this.patchState({ categories: parents, children: formattedChildren })
            },
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            //finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  )

  readonly addImage = this.updater((state, currentFile: File) => ({
    ...state,
    currentFile: currentFile
  }));

  readonly addImages = this.updater((state, selectedFiles: FileList) => ({
    ...state,
    selectedFiles: selectedFiles
  }));
}
