import { Injectable } from '@angular/core';
import { HttpErrorResponse } from '@angular/common/http';
import { ComponentStore } from '@ngrx/component-store';
import { tapResponse } from '@ngrx/operators'
import { GlobalStore } from "../global.store";
import { Seller } from '../../types/seller/seller';
import { SellerApi } from '../../apis/seller.api';
import { UiError } from '../../core/services/exception.service';
import { tap } from 'rxjs/operators';
import { AccountDetails } from '../../types/seller/account-details';
import { Transaction } from '../../types/orders/transaction';
import { BalanceCollection } from '../../types/seller/balance';
import { Withdrawal } from '../../types/seller/withdrawal';
import { Billing } from '../../types/seller/billing';
import { pipe, switchMap } from 'rxjs';
import { Review } from '../../types/seller/review';

export interface ProfileFormState {
  imagePreview: string;
  currentFile?: File;
  data: Seller
  bank_account_details: AccountDetails
  card_details: AccountDetails[],
  transactions: Transaction[],
  balance: BalanceCollection,
  withdrawals: Withdrawal[],
  billing: Billing,
  loading: boolean,
  reviews: Review[]
}

const defaultState: ProfileFormState = {
  imagePreview: '',
  currentFile: undefined,
  data: {} as Seller,
  bank_account_details: {} as AccountDetails,
  card_details: [],
  transactions: [],
  balance: {} as BalanceCollection,
  withdrawals: [],
  billing: {} as Billing,
  loading: false,
  reviews: []
};

@Injectable()
export class ProfileStore extends ComponentStore<ProfileFormState> {
  constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly cards$ = this.select(({ card_details }) => card_details);
  readonly data$ = this.select(({ data }) => data);
  readonly billing$ = this.select(({ billing }) => billing);
  readonly bank_account$ = this.select(({ bank_account_details }) => bank_account_details);

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
    data: state.data,
    transactions: state.transactions,
    balance: state.balance,
    withdrawals: state.withdrawals,
    loading: state.loading,
    reviews: state.reviews,
    card_details: state.card_details
  }))

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

  readonly addCard = this.updater((state, card: AccountDetails) => ({
    ...state,
    card_details: [...state.card_details, card]
  }));

  readonly updateBalanceActivatedFlag = this.updater((state) => ({
    ...state,
    data: { ...state.data, ...{ balance_activated: true } }
  }));

  readonly updateCard = this.updater((state, updatedCard: AccountDetails) => ({
    ...state,
    card_details: state.card_details.map(card =>
      card.id === updatedCard.id ? updatedCard : card
    )
  }));

  readonly removeCard = this.updater((state, cardId: number) => ({
    ...state,
    card_details: state.card_details.filter(card => card.id !== cardId)
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

  deleteBankAccount(id: number) {
    return this._api.deleteBankAccount(id).pipe(
      tap(() => this._globalStore.setLoading(true)),
      tapResponse({
        next: (users) => {
          this.patchState({ bank_account_details: {} as AccountDetails })
          this._globalStore.setSuccess('Deleted successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

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

  selectFile(event: any): void {
    this.patchState({ imagePreview: '' })
    const selectedFiles = event.target.files;

    if (selectedFiles) {
      const file: File | null = selectedFiles.item(0);

      if (file) {
        this.patchState({ imagePreview: '', currentFile: file })

        const reader = new FileReader();

        reader.onload = (e: any) => {
          this.patchState({ imagePreview: e.target.result })

        };

        reader.readAsDataURL(file);
      }
    }
  }

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

  readonly getTransactions = this.effect<void>(
    // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good
    // names. We encourage to choose one of these and use them consistently in your codebase.
    (trigger$) => trigger$.pipe(
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

  readonly getBalance = this.effect<void>(
    // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good
    // names. We encourage to choose one of these and use them consistently in your codebase.
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

  getSellerBankAccountDetails() {
    return this._api.getSellerBankAccountDetails().pipe(
      tap(() => this.patchState({ loading: true })),
      tapResponse({
        next: (data) => this.patchState({ bank_account_details: data as AccountDetails }),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({ loading: false }),
      })
    )
  }

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

  getBilling() {
    return this._api.getBilling().pipe(
      tap(() => this.patchState({ loading: true })),
      tapResponse({
        next: (data) => this.patchState({ billing: data as Billing }),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this.patchState({ loading: false }),
      })
    )
  }

  readonly getSellerCardDetails = this.effect<void>(
    // The name of the source stream doesn't matter: `trigger$`, `source$` or `$` are good
    // names. We encourage to choose one of these and use them consistently in your codebase.
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
}
