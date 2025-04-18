import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {User} from '../../../data/user';
import {catchError, map, pipe, switchMap, tap, throwError} from 'rxjs';
import {UserService} from '../../../service/user.service';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from '../../../shared/store/global.store';


export interface UserState {
  users: User[];
  loading: boolean;
  error: string;
  saveSuccess: boolean;
}

const defaultState: UserState = {
  users: [],
  loading: false,
  error: '',
  saveSuccess: false
};

@Injectable({
  providedIn: 'root'
})
export class UserStore extends ComponentStore<UserState> {
  constructor(private _service: UserService, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly users$ = this.select(({users}) => users);
  private readonly loading$ = this.select((state) => state.loading);
  private readonly error$ = this.select((state) => state.error);

  readonly vm$ = this.select(
    {
      users: this.users$,
      loading: this.loading$,
      error: this.error$,
    },
    {debounce: true}
  );

  readonly delete = this.effect<number>(
    pipe(
      tap(() => this.patchState({loading: true})),
      switchMap((id) => this._service.delete(id).pipe(
          tapResponse({
            next: (users) => {
              this._globalStore.setSuccess('Deleted successfully');
              this.patchState({loading: false, saveSuccess: true})
            },
            error: (error: HttpErrorResponse) => {
              this.patchState({loading: false, saveSuccess: false})
              this._globalStore.setError(error.message)
            },
            finalize: () => this.patchState({loading: false}),
          })
        )
      )
    )
  );

  loadData = () => {
    return this._service.getData().pipe(
      map(response =>
        response.data ? response.data : []
      ),
      catchError((error: HttpErrorResponse) => {
        this._globalStore.setError(error.message)
        return throwError(() => error)
      })
    )
  }
}
