import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Seller} from '../types/seller/seller';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {FilterModel} from '../types/filter.model';

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

  saveBankDetails(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/bank`, payload);
  }

  saveCardDetails(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/account/card`, payload);
  }

  getSellerBankAccountDetails() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/account/bank`);
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

  toggleActive(sellerId: number, active: boolean) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/active`, {active: active, sellerId: sellerId});
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
  }
}
