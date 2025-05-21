import {Injectable} from '@angular/core';
import {Observable, of} from 'rxjs';
import {FilterModel} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {OrderDetail} from '../types/orders/order-detail';
import {HttpClient} from '@angular/common/http';
import {environment} from '../../environments/environment';

export const MODULE = 'orders'

@Injectable({
  providedIn: 'root'
})
export class OrderApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  delete(id: number) {
    alert('deleting')
    return of(true);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any> {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }

  getOrderDetails(orderId: number) {
    return this.httpClient.get(`${environment.apiUrl}/orders/${orderId}`)
  }

  getOrderLogs(orderId: number) {
    return this.httpClient.get(`${environment.apiUrl}/orders/logs/${orderId}`)
  }

  saveOrderDetailStatus(orderItemId: number, payload: any) {
   return this.httpClient.put(`${environment.apiUrl}/orders/details/${orderItemId}`, payload)
  }

  refundItem(orderItemId: number, payload: any) {
   return this.httpClient.post(`${environment.apiUrl}/orders/refund/${orderItemId}`, payload)
  }

  update(id: number, payload: any) {
   return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload)
  }
}
