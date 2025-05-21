import { Injectable } from "@angular/core";
import { tapResponse } from "@ngrx/operators";
import { switchMap, tap } from "rxjs";
import { UiError } from "../../../core/error.model";
import { ComponentStore } from "@ngrx/component-store";
import { SellerApi } from "../../../apis/seller.api";
import { GlobalStore } from "../../../store/global.store";
import { BalanceCollection } from "../../../types/seller/balance";
import { HttpErrorResponse } from "@angular/common/http";
import { Seller } from "../../../types/seller/seller";
import { Transaction } from "../../../types/orders/transaction";

export interface BalancePageState {
    balance: BalanceCollection,
    loading: boolean,
    data: Seller,
    transactions: Transaction[],
}

const defaultState: BalancePageState = {
    balance: {} as BalanceCollection,
    loading: false,
    data: {} as Seller,
    transactions: [],
};

@Injectable()
export class BalancePageStore extends ComponentStore<BalancePageState> {
    constructor(protected _api: SellerApi, protected _globalStore: GlobalStore) {
        super(defaultState);
    }

    vm$ = this.select(state => ({
    data: state.data,
    transactions: state.transactions,
    balance: state.balance,
    loading: state.loading,
  }))

    saveWithdrawal = (payload: Partial<any>) => {
        return this._api.saveWithdrawal(payload).pipe(
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

    readonly getTransactions = this.effect<void>(
        (trigger$) => trigger$.pipe(
            tap(() => this.patchState({ loading: true })),
            switchMap(() =>
                this._api.getTransactions().pipe(
                    tap(() => this.patchState({ loading: true })),
                    tapResponse({
                        next: (data) => this.patchState({ transactions: data as Transaction[] }),
                        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                        finalize: () => this.patchState({ loading: false }),
                    })
                )
            )
        )
    );

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

    readonly getBalance = this.effect<void>(
        (trigger$) => trigger$.pipe(
            tap(() => this.patchState({ loading: true })),
            switchMap(() =>
                this._api.getBalance().pipe(
                    tapResponse({
                        next: (data) => this.patchState({ balance: data as BalanceCollection }),
                        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                        finalize: () => this.patchState({ loading: false }),
                    })
                )
            )
        )
    );

    readonly updateBalanceActivatedFlag = this.updater((state) => ({
        ...state,
        data: { ...state.data, ...{ balance_activated: true } }
    }));

    activateBalance = (payload: Partial<any>) => {
        return this._api.activateBalance(payload).pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (users) => {
                    this._globalStore.setSuccess('Saved successfully')
                    this.updateBalanceActivatedFlag()
                },
                error: (error: HttpErrorResponse) => {
                    this._globalStore.setLoading(false)
                    this._globalStore.setError(UiError(error))
                },
                finalize: () => this._globalStore.setLoading(false),
            })
        )
    }
}