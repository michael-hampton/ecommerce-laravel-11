import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {ComponentStore} from '@ngrx/component-store';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {Seller} from '../../types/seller/seller';
import {SellerApi} from '../../apis/seller.api';
import {UiError} from '../../core/services/exception.service';
import {tap} from 'rxjs/operators';
import {AccountDetails} from '../../types/seller/account-details';
import {Transaction} from '../../types/orders/transaction';
import {Balance} from '../../types/seller/balance';
import {Withdrawal} from '../../types/seller/withdrawal';

export interface ProfileFormState {
  imagePreview: string;
  currentFile?: File;
  data: Seller
  bank_account_details: AccountDetails
  card_details: AccountDetails,
  transactions: Transaction[],
  balance: Balance,
  withdrawals: Withdrawal[]
}

const defaultState: ProfileFormState = {
  imagePreview: '',
  currentFile: undefined,
  data: {} as Seller,
  bank_account_details: {} as AccountDetails,
  card_details: {} as AccountDetails,
  transactions: [],
  balance: {} as Balance,
  withdrawals: []
};

@Injectable()
export class ProfileStore extends ComponentStore<ProfileFormState> {
  constructor(private _api: SellerApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  vm$ = this.select(state => ({
    imagePreview: state.imagePreview,
    data: state.data,
    transactions: state.transactions,
    balance: state.balance,
    withdrawals: state.withdrawals
  }))

  saveData = (payload: Partial<Seller>) => {
    const {id, ...dataCreate} = payload
    const request$ = id ? this._api.update(id, payload) : this._api.create(dataCreate)

    return request$.pipe(
      tap(() => this._globalStore.setLoading(true)),
      tapResponse({
        next: (users) =>  this._globalStore.setSuccess('Saved successfully'),
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

  saveCardDetails = (payload: Partial<any>) => {
    return this._api.saveCardDetails(payload).pipe(
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

  selectFile(event: any): void {
    this.patchState({imagePreview: ''})
    const selectedFiles = event.target.files;

    if (selectedFiles) {
      const file: File | null = selectedFiles.item(0);

      if (file) {
        this.patchState({imagePreview: '', currentFile: file})

        const reader = new FileReader();

        reader.onload = (e: any) => {
          this.patchState({imagePreview: e.target.result})

        };

        reader.readAsDataURL(file);
      }
    }
  }

  getData(sellerId: number) {
    return this._api.getSeller(sellerId).pipe(
      tapResponse({
        next: (data) => this.patchState({data: data as Seller}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getTransactions() {
    return this._api.getTransactions().pipe(
      tapResponse({
        next: (data) => this.patchState({transactions: data as Transaction[]}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getBalance() {
    return this._api.getBalance().pipe(
      tapResponse({
        next: (data) => this.patchState({balance: data as Balance}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getSellerBankAccountDetails() {
    return this._api.getSellerBankAccountDetails().pipe(
      tapResponse({
        next: (data) => this.patchState({bank_account_details: data as AccountDetails}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getWithdrawals() {
    return this._api.getWithdrawals().pipe(
      tapResponse({
        next: (data) => this.patchState({withdrawals: data as Withdrawal[]}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }

  getSellerCardDetails() {
    return this._api.getSellerCardDetails().pipe(
      tapResponse({
        next: (data) => this.patchState({card_details: data as AccountDetails}),
        error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
        finalize: () => this._globalStore.setLoading(false),
      })
    )
  }
}
