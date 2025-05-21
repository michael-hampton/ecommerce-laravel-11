import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import { Category } from '../types/support/category';

export const MODULE = 'faq-categories'

@Injectable({
  providedIn: 'root'
})
export class SupportCategoryApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  create(payload: Partial<Category>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  update(id: number, payload: Partial<Category>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  delete(id: number){
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  search(filter: FilterModel): Observable<any>{
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }

  getAll() {
    return this.httpClient.get(`${environment.apiUrl}/${MODULE}`)
  }
}
