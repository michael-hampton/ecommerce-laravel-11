import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from "rxjs";
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';

export const MODULE = 'dashboard'

@Injectable({
  providedIn: 'root'
})
export class DashboardApi {

  private data = {
    total: 100,
    totalAmount: 3200,
    totalOrdered: 50,
    totalOrderedAmount: 3200,
    totalDelivered: 20,
    totalDeliveredAmount: 2000,
    totalCancelled: 10,
    totalCancelledAmount: 100
  }

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  getData(){
    //return of({data: this.data})
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}`);
  }
}
