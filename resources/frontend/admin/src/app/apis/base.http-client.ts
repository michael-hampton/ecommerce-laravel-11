import {HttpClient, HttpParams} from '@angular/common/http';
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
}
