import {HttpClient, HttpHeaders, HttpParams} from '@angular/common/http';
import {environment} from '../../environments/environment';
import {MODULE} from './product.api';
import {FilterModel} from '../types/filter.model';
import {Injectable} from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class BaseHttpClient
{
  constructor(private httpclient: HttpClient) { }
  get(filter: FilterModel, url: string) {
    const params = new HttpParams({fromObject: filter})
    return this.httpclient.get(`${environment.apiUrl}/${url}`, {params: params});
  }

  getAll(url:string) {
    return this.httpclient.get(`${environment.apiUrl}/${url}`);
  }

  getById(url: string) {
    return this.httpclient.get(`${environment.apiUrl}/${url}`);
  }

  update(url: string, payload: any) {
    const formData = this.getFormData(payload)
    formData.append('_method', 'PUT')

    return this.httpclient.post(`${url}`,
      formData,
      {headers: new HttpHeaders({ContentType: 'application/json'})}
    );
  }

  getFormData(object: any): FormData  {
    const formData = new FormData();
    Object.keys(object).forEach(key => formData.append(key, object[key]));
    return formData;
  }
}
