import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import { GlobalStore } from '../../../../store/global.store';
import { NotificationApi } from '../../../../apis/notification.api';
import { Observable, switchMap, tap } from 'rxjs';
import { FilterModel } from '../../../../types/filter.model';
import { UiError } from '../../../error.model';
import { Notifications } from '../../../../types/notifications/notifications';


export interface TopbarState {
    notifications: Notifications[]
}

const defaultState: TopbarState = {
    notifications: []
};

@Injectable()
export class TopbarStore extends ComponentStore<TopbarState> {
  constructor(private _api: NotificationApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    notifications: state.notifications,
  }))

  loadData = this.effect((filter$: Observable<FilterModel>) =>
      filter$.pipe(
        tap(() => this._globalStore.setLoading(true)),
        switchMap((filter: FilterModel) => this._api.getData(filter).pipe(
            tapResponse({
              next: (data) => this.patchState({notifications: data}),
              error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
              complete: () => this._globalStore.setLoading(false)
            })
          )
        )
      )
    );
}
