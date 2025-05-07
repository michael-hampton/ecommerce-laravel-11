import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Seller} from '../types/seller/seller';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {FilterModel} from '../types/filter.model';
import { Review } from '../types/seller/review';

export const MODULE = 'sellers'

@Injectable({
  providedIn: 'root'
})
export class SellerApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Seller>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  saveBilling(payload: Partial<Seller>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/billing`, payload);
  }

  saveBankDetails(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/bank`, payload);
  }

  deleteBankAccount(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/account/bank/${id}`);
  }

  addNewCard(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/card`, payload);
  }

  updateCard(payload: Partial<any>, id: number) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/account/card/${id}`, payload);
  }

  removeCard(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/account/card/${id}`);
  }

  deleteAccount(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`);
  }

  saveReviewReply(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/reviews/reply`, payload);
  }

  saveWithdrawal(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/balance/withdraw`, payload);
  }

  activateBalance(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/balance/activate`, payload);
  }

  getSellerBankAccountDetails() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/bank`);
  }

  getWithdrawals() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/balance/withdraw`);
  }

  getBilling() {
    return this.httpClient.get(`${environment.apiUrl}/billing`);
  }

  getSellerCardDetails() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/card`);
  }

  update(id: number, payload: Partial<Seller>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  getSeller(id: number) {
    return this.baseHttpClient.getById(`${MODULE}/${id}`);
  }

  getTransactions() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/transactions`);
  }

  getReviews() {
    return this.httpClient.get(`${environment.apiUrl}/reviews`);
  }

  getBalance() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/balance`);
  }

  toggleActive(sellerId: number, active: boolean) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/active`, {active: active, sellerId: sellerId});
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
  }
}
