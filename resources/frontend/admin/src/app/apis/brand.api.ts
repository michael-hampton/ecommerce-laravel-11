import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Brand} from '../types/brands/brand';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {BaseHttpClient} from './base.http-client';
import {Attribute} from '../types/attributes/attribute';
import {environment} from '../../environments/environment';

export const MODULE = 'brands'

@Injectable({
  providedIn: 'root'
})
export class BrandApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Brand>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, this.baseHttpClient.getFormData(payload));
  }

  update(id: number, payload: Partial<Brand>) {
    return this.baseHttpClient.update(`${environment.apiUrl}/${MODULE}/${id}`, payload)

  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
  }
}
