import { Injectable } from '@angular/core';
import {Observable, of} from 'rxjs';
import {formatDate} from '@angular/common';
import {Coupon} from "../types/coupons/coupon";
import {FilterModel} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';

export const MODULE = 'notifications'

@Injectable({
  providedIn: 'root'
})
export class NotificationApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
  }

  getTypes(): Observable<any>{
    return this.httpClient.get(`${environment.apiUrl}/notification-types`);
  }

  saveNotifications(payload: any) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload)
  }
}
