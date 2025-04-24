import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable} from 'rxjs';
import {Attribute} from '../types/attributes/attribute';
import {FilterModel} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';

export const MODULE = 'attributes'

@Injectable({
  providedIn: 'root'
})
export class AttributeApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Attribute>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  update(id: number, payload: Partial<Attribute>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
  }
}
