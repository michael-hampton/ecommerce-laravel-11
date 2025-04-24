import { Injectable } from '@angular/core';
import {HttpClient, HttpParams} from '@angular/common/http';
import {delay, Observable, of} from 'rxjs';
import {Product, SelectedAttributes} from "../types/products/product";
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {environment} from '../../environments/environment';
import {BaseHttpClient} from './base.http-client';
import {Attribute} from '../types/attributes/attribute';

export const MODULE = 'products'

@Injectable({
  providedIn: 'root'
})
export class ProductApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) { }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Product>) {
    const formData= new FormData();
    payload.attributes.filter(x => x.selected === true)
      .forEach((item) =>
        formData.append("attribute_values[]", item.attribute_value_id.toString())
      )
    delete payload['attributes']
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, this.baseHttpClient.getFormData(payload, formData));
  }

  update(id: number, payload: Partial<Product>) {
    return this.baseHttpClient.update(`${environment.apiUrl}/${MODULE}/${id}`, payload)

  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
  }
}
