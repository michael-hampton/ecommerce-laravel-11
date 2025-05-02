import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import { GlobalStore } from '../../global.store';
import { UiError } from '../../../core/error.model';
import { Article } from '../../../types/support/article';
import { SupportArticleApi } from '../../../apis/support-article.api';
import { switchMap } from 'rxjs';
import { Category } from '../../../types/support/category';
import { Tag } from '../../../types/support/tag';
import { PagedData } from '../../../types/filter.model';


export interface SupportArticleFormState {
  categories: Category[]
  tags: Tag[]
}

const defaultState: SupportArticleFormState = {
  categories: [],
  tags: []
};

@Injectable()
export class SupportArticleFormStore extends ComponentStore<SupportArticleFormState> {
  constructor(private _api: SupportArticleApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly categories$ = this.select(({ categories }) => categories);
  readonly tags$ = this.select(({ tags }) => tags);


  readonly vm$ = this.select(
    {
      categories: this.categories$,
      tags: this.tags$,

    },
    { debounce: true }
  );

  saveData = (payload: Partial<Article>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)
    this._globalStore.setLoading(true)

    return request$.pipe(
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this._globalStore.setLoading(false)
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setLoading(false)
          this._globalStore.setError(UiError(error))
        },
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  readonly getCategories = this.effect<void>(
      // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good 
      // names. We encourage to choose one of these and use them consistently in your codebase.
      (trigger$) => trigger$.pipe(
        switchMap(() =>
          this._api.getCategories().pipe(
            tapResponse({
              next: (data) =>  this.patchState({ categories: (data as PagedData<Category>).data as Category[] }),
              error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
              finalize: () => this._globalStore.setLoading(false),
            })
          )
        )
      )
    );

    readonly getTags = this.effect<void>(
      (trigger$) => trigger$.pipe(
        switchMap(() =>
          this._api.getTags().pipe(
            tapResponse({
              next: (tags) => this.patchState({ tags: tags as Tag[] }),
              error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
              finalize: () => this._globalStore.setLoading(false),
            })
          )
        )
      )
    );
}
