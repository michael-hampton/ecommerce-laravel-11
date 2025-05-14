import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { Product } from "../types/products/product";
import { FilterModel } from '../types/filter.model';
import { environment } from '../../environments/environment';
import { BaseHttpClient } from './base.http-client';

export const MODULE = 'products'

@Injectable({
  providedIn: 'root'
})
export class ProductApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }

  create(payload: Partial<Product>) {
    const formData = new FormData();
    payload.attributes.filter(x => x.selected === true)
      .forEach((item) =>
        formData.append("attribute_values[]", item.attribute_value_id.toString())
      )

    if (payload.images) {
      Array.from(payload.images).forEach((file: File) => { formData.append('images[]', file); });
    }
    delete payload['attributes']
    delete payload['images']
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, this.baseHttpClient.getFormData(payload, formData));
  }

  update(id: number, payload: Partial<Product>) {
    const formData = new FormData();
    payload.attributes.filter(x => x.selected === true)
      .forEach((item) =>
        formData.append("attribute_values[]", item.attribute_value_id.toString())
      )

    if (payload.images) {
      Array.from(payload.images).forEach((file: File) => { formData.append('images[]', file); });
    }

    delete payload['attributes']
    delete payload['images']
    formData.append('_method', 'PUT')
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/${id}`, this.baseHttpClient.getFormData(payload, formData))

  }

  getData(filter: FilterModel): Observable<any> {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}/search`, filter);
  }

  toggleActive(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}/active`)
  }
}
