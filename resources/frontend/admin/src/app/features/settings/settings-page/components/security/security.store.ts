import { HttpErrorResponse } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { Seller } from "../../../../../types/seller/seller";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { UiError } from "../../../../../core/error.model";
import { tap } from "rxjs";

export interface SecurityState {
    data: Seller
    loading: boolean,
}

const defaultState: SecurityState = {
    data: {} as Seller,
    loading: false,
};

@Injectable()
export class SecurityStore extends ComponentStore<SecurityState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    readonly data$ = this.select(({ data }) => data);

    getData(sellerId: number) {
        this.patchState({ loading: true })
        return this._api.getSeller(sellerId).pipe(
            tapResponse({
                next: (data) => {
                    this.patchState({ data: data as Seller })
                },
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this.patchState({ loading: false }),
            })
        )
    }

    deleteAccount(id: number) {
        return this._api.deleteAccount(id).pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (users) => this._globalStore.setSuccess('Deleted successfully'),
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this._globalStore.setLoading(false),
            })
        )
    }

    resetPassword(payload: any) {
        return this._api.resetPassword(payload).pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (users) => this._globalStore.setSuccess('Deleted successfully'),
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this._globalStore.setLoading(false),
            })
        )
    }
}