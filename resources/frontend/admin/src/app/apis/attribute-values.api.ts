import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { AttributeValue } from '../types/attribute-values/attribute-value';
import { FilterModel, PagedData } from '../types/filter.model';
import { BaseHttpClient } from './base.http-client';
import { environment } from '../../environments/environment';

export const MODULE = 'attribute-values'

@Injectable({
  providedIn: 'root'
})
export class AttributeValuesApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  create(payload: Partial<AttributeValue>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  update(id: number, payload: Partial<AttributeValue>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  getData(filter: FilterModel): Observable<any> {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }
}
