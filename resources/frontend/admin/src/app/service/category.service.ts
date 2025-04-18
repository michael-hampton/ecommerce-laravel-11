import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';
import {of} from 'rxjs';
import {Category} from '../data/category';

export const MODULE = 'admin/categories'

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  private categories: Category[] = [
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

  constructor(private httpclient: HttpClient) { }

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

  getData(){
    return of({data: this.categories})
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
