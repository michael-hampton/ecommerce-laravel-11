import { Injectable } from "@angular/core";
import { NotificationApi } from "../../../../../apis/notification.api";
import { GlobalStore } from "../../../../../store/global.store";
import { HttpErrorResponse } from "@angular/common/http";
import { tap } from "rxjs";
import { tapResponse } from "@ngrx/operators";
import { UiError } from "../../../../../core/error.model";
import { NotificationTypeCollection, Type } from "../../../../../types/notifications/type";
import { ComponentStore } from "@ngrx/component-store";
import { UserNotification } from "../../../../../types/notifications/user-notification";

export interface NotificationState {
    loading: boolean,
    notification_types: NotificationTypeCollection,
}

const defaultState: NotificationState = {
    loading: false,
    notification_types: {} as NotificationTypeCollection,
};

@Injectable()
export class NotificationStore extends ComponentStore<NotificationState> {
    constructor(private _notificationApi: NotificationApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    vm$ = this.select(state => ({
        loading: state.loading,
        notification_types: state.notification_types
    }))

    getNotificationTypes(userId: number) {
        return this._notificationApi.getTypes(userId).pipe(
            tap(() => this.patchState({ loading: true })),
            tapResponse({
                next: (data) => this.patchState({ notification_types: data }),
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this.patchState({ loading: false }),
            })
        )
    }

    saveNotificationTypes = (payload: Partial<any>) => {
        return this._notificationApi.saveNotifications(payload).pipe(
            tap(() => this._globalStore.setLoading(true)),
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
}