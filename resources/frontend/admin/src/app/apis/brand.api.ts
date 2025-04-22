import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Brand} from '../types/brands/brand';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'brands'

@Injectable({
  providedIn: 'root'
})
export class BrandApi {

  private brands: Brand[] = [
    {
      id: 1, name: 'Brand 1', slug: 'brand-1', image: 'test',
      products: 4
    },
    {
      id: 2, name: 'Brand 1', slug: 'brand-2', image: 'test',
      products: 5
    },
    {
      id: 3, name: 'Brand 1', slug: 'brand-3', image: 'test',
      products: 6
    },
    {
      id: 4, name: 'Brand 1', slug: 'brand-4', image: 'test',
      products: 7
    },
    {
      id: 5, name: 'Brand 1', slug: 'brand-5', image: 'test',
      products: 8
    },
  ]

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.brands);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Brand>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Brand>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.brands, current_page: 1, total: this.brands.length} as PagedData<Brand>)
  }
}
