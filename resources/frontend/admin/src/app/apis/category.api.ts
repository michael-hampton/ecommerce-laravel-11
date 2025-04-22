import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Category} from '../types/categories/category';
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'categories'

@Injectable({
  providedIn: 'root'
})
export class CategoryApi {

  private categories = [
    {
      id: 1, name: 'Category 1', slug: 'category-1',
      image: '',
      parent_id: 0,
      products: 5
    },
    {
      id: 2, name: 'Category 1', slug: 'category-2',
      image: '',
      parent_id: 0,
      products: 5
    },
    {
      id: 3, name: 'Category 1', slug: 'category-3',
      image: '',
      parent_id: 0,
      products: 5
    },
    {
      id: 4, name: 'Category 1', slug: 'category-4',
      image: '',
      parent_id: 0,
      products: 5
    },
    {
      id: 5,
      name: 'Category 1',
      slug: 'category-5',
      image: '',
      parent_id: 0,
      products: 6,
      subcategories: [{
        id: 1,
        name: 'subcategory 1',
        slug: '',
        image: '',
        parent_id: 0,
        products: 5
      }, {
        id: 2,
        name: 'subcategory 2',
        slug: '',
        image: '',
        parent_id: 0,
        products: 5
      }, {
        id: 3,
        name: 'subcategory 3',
        slug: '',
        image: '',
        parent_id: 0,
        products: 5
      }]
    },
  ]

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.categories);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Category>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Category>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any>{
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.categories, current_page: 1, total: this.categories.length} as PagedData<Category>)
  }
}
