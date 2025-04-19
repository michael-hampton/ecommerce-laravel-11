import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {of} from "rxjs";

export const MODULE = 'admin'

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

  constructor(private httpclient: HttpClient) { }

  getData(){
    return of({data: this.data})
    //return this.httpclient.get(`${environment.apiUrl}/${MODULE}`);
  }
}
