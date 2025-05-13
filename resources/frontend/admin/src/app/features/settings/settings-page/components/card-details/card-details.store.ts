import { Injectable } from "@angular/core";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { pipe, switchMap, tap } from "rxjs";
import { AccountDetails } from "../../../../../types/seller/account-details";
import { UiError } from "../../../../../core/error.model";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { HttpErrorResponse } from "@angular/common/http";

export interface CardDetailsState {
    card_details: AccountDetails[],
    loading: boolean
}

const defaultState: CardDetailsState = {
    card_details: [],
    loading: false
};

@Injectable()
export class CardDetailsStore extends ComponentStore<CardDetailsState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    readonly cards$ = this.select(({ card_details }) => card_details);

    vm$ = this.select(state => ({
        loading: state.loading,
        card_details: state.card_details,
    }))

    readonly getSellerCardDetails = this.effect<void>(
        (trigger$) => trigger$.pipe(
            tap(() => this.patchState({ loading: true })),
            switchMap(() =>
                this._api.getSellerCardDetails().pipe(
                    tapResponse({
                        next: (data) => this.patchState({ card_details: data as AccountDetails[] }),
                        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                        finalize: () => this.patchState({ loading: false }),
                    })
                )
            )
        )
    );

    readonly addCard = this.updater((state, card: AccountDetails) => ({
        ...state,
        card_details: [...state.card_details, card]
    }));

    readonly updateCard = this.updater((state, updatedCard: AccountDetails) => ({
        ...state,
        card_details: state.card_details.map(card =>
            card.id === updatedCard.id ? updatedCard : card
        )
    }));

    saveCardDetails = (payload: Partial<any>) => {
        const request$ = payload['id'] ? this._api.updateCard(payload, payload['id']) : this._api.addNewCard(payload)
        return request$.pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (card: any) => {
                    if (!payload['id']) {
                        this.addCard(card.data)
                    } else {
                        this.updateCard(card.data)
                    }
                    this._globalStore.setSuccess('Saved successfully')
                },
                error: (error: HttpErrorResponse) => {
                    this._globalStore.setLoading(false)
                    this._globalStore.setError(UiError(error))
                },
                finalize: () => this._globalStore.setLoading(false),
            })
        )
    }

    readonly removeCard = this.updater((state, cardId: number) => ({
        ...state,
        card_details: state.card_details.filter(card => card.id !== cardId)
    }));



    readonly deleteCard = this.effect<number>(
        pipe(
            tap(() => this._globalStore.setLoading(true)),
            switchMap((id) => this._api.removeCard(id).pipe(
                tapResponse({
                    next: (users) => {
                        this.removeCard(id)
                        this._globalStore.setSuccess('Deleted successfully');
                        //this.patchState({loading: false, saveSuccess: true})
                    },
                    error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                    finalize: () => this._globalStore.setLoading(false),
                })
            )
            )
        )
    );
}