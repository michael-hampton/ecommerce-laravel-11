import { HttpErrorResponse } from "@angular/common/http";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { tap } from "rxjs";
import { Review } from "../../../../../types/seller/review";
import { UiError } from "../../../../../core/error.model";
import { SellerApi } from "../../../../../apis/seller.api";
import { GlobalStore } from "../../../../../store/global.store";
import { Injectable } from "@angular/core";

export interface ReviewState {
    reviews: Review[],
    loading: boolean
}

const defaultState: ReviewState = {
    reviews: [],
    loading: false
};

@Injectable()
export class ReviewStore extends ComponentStore<ReviewState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
        super(defaultState);
    }

    vm$ = this.select(state => ({
        reviews: state.reviews,
    }))
    
    getReviews() {
        return this._api.getReviews().pipe(
            tap(() => this.patchState({ loading: true })),
            tapResponse({
                next: (data) => this.patchState({ reviews: data as Review[] }),
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this.patchState({ loading: false }),
            })
        )
    }

    saveReviewReply = (payload: Partial<any>) => {
        return this._api.saveReviewReply(payload).pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (data: any) => {
                    this._globalStore.setSuccess('Saved successfully')
                    this.patchState((state) => ({
                        reviews: state.reviews.map((t) => (Number(t.id) === Number(data.data.id) ? { ...data.data } : t)),
                    }));
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