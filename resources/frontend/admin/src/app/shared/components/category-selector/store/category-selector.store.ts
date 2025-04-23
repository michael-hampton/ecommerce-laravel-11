import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {Category} from '../../../../types/categories/category';
import {GlobalStore} from '../../../../store/global.store';
import {LookupApi} from '../../../../apis/lookup.api';
import {pipe, switchMap} from 'rxjs';
import {UiError} from '../../../../core/error.model';


export interface CategoryFormState {
  imagePreview: string;
  currentFile?: File;
  categories?: Category[],
  children?: Record<number, Category[]>
}

const defaultState: CategoryFormState = {
  imagePreview: '',
  currentFile: undefined,
  categories: [],
  children: []
};

@Injectable({
  providedIn: 'root'
})
export class CategorySelectorStore extends ComponentStore<CategoryFormState> {
  constructor(private _globalStore: GlobalStore, private _lookupService: LookupApi) {
    super(defaultState);
  }

  readonly file$ = this.select(state => state.currentFile);
  readonly image$ = this.select(({imagePreview}) => imagePreview);
  readonly children$ = this.select(({children}) => children);

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
    categories: state.categories,
    children: state.children
  }))

  getCategories = this.effect<void>(
    // Standalone observable chain. An Observable<void> will be attached by ComponentStore.
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

              this.patchState({categories: parents, children: formattedChildren})
            },
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            //finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  )
}
