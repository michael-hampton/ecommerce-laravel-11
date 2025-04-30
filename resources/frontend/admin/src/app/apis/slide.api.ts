import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable, of } from 'rxjs';
import { Slide } from "../types/slides/slide";
import { FilterModel, PagedData } from '../types/filter.model';
import { Category } from '../types/categories/category';
import { User } from '../types/users/user';
import { BaseHttpClient } from './base.http-client';
import { Attribute } from '../types/attributes/attribute';
import { environment } from '../../environments/environment';

export const MODULE = 'slides'

@Injectable({
  providedIn: 'root'
})
export class SlideApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  toggleActive(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}/active`)
  }

  create(payload: Partial<Slide>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, this.baseHttpClient.getFormData(payload));
  }

  update(id: number, payload: Partial<Slide>) {
    return this.baseHttpClient.update(`${environment.apiUrl}/${MODULE}/${id}`, payload)
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
  }
}
