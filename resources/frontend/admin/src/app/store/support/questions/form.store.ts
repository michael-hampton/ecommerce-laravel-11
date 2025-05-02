import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { GlobalStore } from '../../global.store';
import { UiError } from '../../../core/error.model';
import { Question } from '../../../types/support/question';
import { Category } from '../../../types/support/category';
import { SupportQuestionApi } from '../../../apis/support-question.api';
import { switchMap } from 'rxjs';
import { PagedData } from '../../../types/filter.model';



export interface SupportQuestionFormState {
  categories: Category[]
}

const defaultState: SupportQuestionFormState = {
  categories: []
};

@Injectable()
export class SupportQuestionFormStore extends ComponentStore<SupportQuestionFormState> {
  constructor(private _api: SupportQuestionApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly categories$ = this.select(({ categories }) => categories);


  readonly vm$ = this.select(
    {
      categories: this.categories$,

    },
    { debounce: true }
  );

  saveData = (payload: Partial<Question>) => {
    const { id, ...dataCreate } = payload
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
}
