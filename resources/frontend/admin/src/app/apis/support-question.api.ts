import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import { Question } from '../types/support/question';

export const MODULE = 'faq-questions'

@Injectable({
  providedIn: 'root'
})
export class SupportQuestionApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  create(payload: Partial<Question>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  update(id: number, payload: Partial<Question>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  getCategories() {
    return this.httpClient.get(`${environment.apiUrl}/faq-categories?sortBy=name&sortDir=asc`);
  }

  delete(id: number){
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  getData(filter: FilterModel): Observable<any>{
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }
}
