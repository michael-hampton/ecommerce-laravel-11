import { Injectable } from '@angular/core';
import {Observable, of} from 'rxjs';
import {formatDate} from '@angular/common';
import {Coupon} from "../types/coupons/coupon";
import {FilterModel} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'coupons'

@Injectable({
  providedIn: 'root'
})
export class CouponApi {

  constructor(private baseHttpClient: BaseHttpClient) { }

  create(payload: Partial<Coupon>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Coupon>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  delete(id: number) {
    alert('deleting')
    return of(true);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.coupons, current_page: 1, total: this.coupons.length} as PagedData<Coupon>)
  }
}
