import { HttpErrorResponse } from "@angular/common/http";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { switchMap, tap } from "rxjs";
import { Withdrawal } from "../../../../../types/seller/withdrawal";
import { UiError } from "../../../../../core/error.model";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { Injectable } from "@angular/core";

export interface WithdrawalState {
    withdrawals: Withdrawal[],
    loading: boolean
}

const defaultState: WithdrawalState = {
    withdrawals: [],
    loading: false
};

@Injectable()
export class WithdrawalStore extends ComponentStore<WithdrawalState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    vm$ = this.select(state => ({
        withdrawals: state.withdrawals,
        loading: state.loading
    }))

    readonly getWithdrawals = this.effect<void>(
        // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good
        // names. We encourage to choose one of these and use them consistently in your codebase.
        (trigger$) => trigger$.pipe(
            tap(() => this.patchState({ loading: true })),
            switchMap(() =>
                this._api.getWithdrawals().pipe(
                    tapResponse({
                        next: (data) => this.patchState({ withdrawals: data as Withdrawal[] }),
                        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                        finalize: () => this.patchState({ loading: false }),
                    })
                )
            )
        )
    );
}