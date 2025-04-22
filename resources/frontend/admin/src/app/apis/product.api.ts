import { Injectable } from '@angular/core';
import {HttpClient, HttpParams} from '@angular/common/http';
import {delay, Observable, of} from 'rxjs';
import {Product} from "../types/products/product";
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {environment} from '../../environments/environment';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'products'

@Injectable({
  providedIn: 'root'
})
export class ProductApi {

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(true);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Product>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Product>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
  }
}
