import { HttpErrorResponse } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { Seller } from "../../../../../types/seller/seller";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { UiError } from "../../../../../core/error.model";
import { tap } from "rxjs";

export interface ShopState {
    data: Seller
    loading: boolean,
}

const defaultState: ShopState = {
    data: {} as Seller,
    loading: false,
};

@Injectable()
export class ShopStore extends ComponentStore<ShopState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    readonly data$ = this.select(({ data }) => data);

    vm$ = this.select(state => ({
        data: state.data,
        loading: state.loading,
    }))

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

    saveData = (payload: Partial<Seller>) => {
        const { id, ...dataCreate } = payload
        const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)

        return request$.pipe(
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