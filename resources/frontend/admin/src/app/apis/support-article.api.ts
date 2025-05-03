import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { FilterModel, PagedData } from '../types/filter.model';
import { BaseHttpClient } from './base.http-client';
import { environment } from '../../environments/environment';
import { Article } from '../types/support/article';

export const MODULE = 'faq-articles'

@Injectable({
    providedIn: 'root'
})
export class SupportArticleApi {

    constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

    create(payload: Partial<Article>) {
        return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
    }

    update(id: number, payload: Partial<Article>) {
        return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
    }

    delete(id: number) {
        return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
    }

    getData(filter: FilterModel): Observable<any> {
        return this.baseHttpClient.get(filter, MODULE);
    }

    getCategories() {
        return this.httpClient.get(`${environment.apiUrl}/faq-categories?sortBy=name&sortDir=asc`);
      }

    getTags() {
        return this.httpClient.get(`${environment.apiUrl}/faq-tags`);
    }
}
