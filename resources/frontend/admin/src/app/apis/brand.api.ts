import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Brand} from '../types/brands/brand';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';

export const MODULE = 'admin/brands'

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

  constructor(private httpclient: HttpClient) { }

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

  getData(filter: FilterModel): Observable<PagedData<Brand>>{
    return of({data: this.brands, page: 1, totalCount: this.brands.length} as PagedData<Brand>)

    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
