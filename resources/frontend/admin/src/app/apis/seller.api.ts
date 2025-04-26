import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from 'rxjs';
import {Seller} from '../types/seller/seller';
import {BaseHttpClient} from './base.http-client';
import {Attribute} from '../types/attributes/attribute';
import {environment} from '../../environments/environment';

export const MODULE = 'sellers'

@Injectable({
  providedIn: 'root'
})
export class SellerApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Seller>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  saveBankDetails(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/bank`, payload);
  }

  saveCardDetails(payload: Partial<any>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/card`, payload);
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

  getSeller(id: number){
    return this.baseHttpClient.getById(`${MODULE}/${id}`);
  }
}
