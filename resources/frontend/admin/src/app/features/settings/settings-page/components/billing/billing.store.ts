import { HttpErrorResponse } from "@angular/common/http";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { tap } from "rxjs";
import { UiError } from "../../../../../core/error.model";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { Seller } from "../../../../../types/seller/seller";
import { Injectable } from "@angular/core";

export interface BillingState {
    loading: boolean,
}

const defaultState: BillingState = {
    loading: false,
};

@Injectable()
export class BillingStore extends ComponentStore<BillingState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    vm$ = this.select(state => ({
        loading: state.loading,
    }))

    saveBilling = (payload: Partial<Seller>) => {
        const { id, ...dataCreate } = payload

        return this._api.saveBilling(payload).pipe(
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