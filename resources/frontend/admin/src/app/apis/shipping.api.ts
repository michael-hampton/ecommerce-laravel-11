import {Injectable} from '@angular/core';
import {Observable, of} from 'rxjs';
import {Shipping} from "../types/shipping/shipping";
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {Country} from '../types/countries/country';

export const MODULE = 'delivery-methods'

@Injectable({
  providedIn: 'root'
})
export class ShippingApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  create(payload: Partial<Shipping>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  getCouriers() {
    return this.httpClient.get(`${environment.apiUrl}/couriers`);
  }

  getCountries() {
    return this.httpClient.get(`${environment.apiUrl}/countries`);
  }

  getDataForCountry(countryId: number) {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}/${countryId}`);
  }

  getData(filter: FilterModel) {
   return this.baseHttpClient.get(filter, MODULE);
  }

  update(id: number, payload: any) {
   payload.append('_method', 'put');
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }
}
