import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { tap } from "rxjs";
import { AccountDetails } from "../../../../../types/seller/account-details";
import { HttpErrorResponse } from "@angular/common/http";
import { UiError } from "../../../../../core/error.model";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { Injectable } from "@angular/core";

export interface BankDetailsState {
    loading: boolean,
    bank_account_details: AccountDetails,
    editingBankDetails: boolean
}

const defaultState: BankDetailsState = {
    loading: false,
    bank_account_details: {} as AccountDetails,
    editingBankDetails: false
};

@Injectable()
export class BankDetailsStore extends ComponentStore<BankDetailsState> {

    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    readonly bank_account$ = this.select(({ bank_account_details }) => bank_account_details);
    vm$ = this.select(state => ({
        loading: state.loading,
        editingBankDetails: state.editingBankDetails
    }))

    deleteBankAccount(id: number) {
        return this._api.deleteBankAccount(id).pipe(
            tap(() => this.patchState({ loading: true })),
            tapResponse({
                next: (users) => {
                    this.patchState({ bank_account_details: {} as AccountDetails })
                    this._globalStore.setSuccess('Deleted successfully');
                    //this.patchState({loading: false, saveSuccess: true})
                },
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this.patchState({ loading: false }),
            })
        )
    }

    saveBankDetails = (payload: Partial<any>) => {
        return this._api.saveBankDetails(payload).pipe(
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

    readonly toggleForm = this.updater((state: BankDetailsState) => {
        return {
            ...state,
            editingBankDetails: !state.editingBankDetails
        };
    });
}