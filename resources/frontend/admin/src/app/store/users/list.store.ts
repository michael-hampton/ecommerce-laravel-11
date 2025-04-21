import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {User} from "../../types/users/user";
import {UserApi} from '../../apis/user.api';
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';


export interface UserState {
  users: User[];
}

const defaultState: UserState = {
  users: [],
};

@Injectable({
  providedIn: 'root'
})
export class UserStore extends ComponentStore<UserState> {
  constructor(private _api: UserApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly users$ = this.select(({users}) => users);

  readonly vm$ = this.select(
    {
      users: this.users$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((id) => this._api.delete(id).pipe(
          tapResponse({
            next: (users) => {
              this._globalStore.setSuccess('Deleted successfully');
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
      )
    )
  );

  loadData = () => {
    return this._api.getData().pipe(
      map(response =>
        response.data ? response.data : []
      ),
      catchError((error: HttpErrorResponse) => {
        this._globalStore.setError(UiError(error))
        return throwError(() => error)
      })
    )
  }
}
