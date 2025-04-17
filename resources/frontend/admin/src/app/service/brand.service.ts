import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';
import {of} from 'rxjs';
import {Brand} from '../data/brand';

export const MODULE = 'admin/brands'

@Injectable({
  providedIn: 'root'
})
export class BrandService {

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

  getData(){
    return of(this.brands)
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
