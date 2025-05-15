import { Injectable } from '@angular/core';
import {Observable, of} from 'rxjs';
import {formatDate} from '@angular/common';
import {Coupon} from "../types/coupons/coupon";
import {FilterModel} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';

export const MODULE = 'coupons'

@Injectable({
  providedIn: 'root'
})
export class CouponApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  create(payload: Partial<Coupon>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  update(id: number, payload: Partial<Coupon>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  getData(filter: FilterModel): Observable<any>{
   return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }
}
