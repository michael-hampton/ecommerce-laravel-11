import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';
import {of} from 'rxjs';
import {Product} from '../data/product';

export const MODULE = 'admin/products'

@Injectable({
  providedIn: 'root'
})
export class ProductService {

  private products: Product[] = [
    {
      id: 1, name: 'Category 1', slug: 'category-1',
      short_description: '',
      description: '',
      regular_price: 0,
      sale_price: 0,
      stock_status: '',
      featured: true,
      quantity: 0,
      images: '',
      image: '',
      brand_id: 0,
      category_id: 0,
      SKU: '',
      seller_id: 0,
      has_stock: true,
      category: {
        id: 1,
        name: 'cat 1',
        slug: '',
        image: '',
        parent_id: 0
      },
      brand: {
        id: 1,
        name: 'brand 1',
        slug: '',
        image: '',
        products: 0
      }
    },
    {
      id: 2, name: 'Category 1', slug: 'category-2',
      short_description: '',
      description: '',
      regular_price: 0,
      sale_price: 0,
      stock_status: '',
      has_stock: true,
      featured: true,
      quantity: 0,
      images: '',
      image: '',
      brand_id: 0,
      category_id: 0,
      SKU: '',
      seller_id: 0,
      category: {
        id: 1,
        name: 'cat 1',
        slug: '',
        image: '',
        parent_id: 0
      },
      brand: {
        id: 1,
        name: 'brand 1',
        slug: '',
        image: '',
        products: 0
      }
    },
    {
      id: 3, name: 'Category 1', slug: 'category-3',
      short_description: '',
      description: '',
      regular_price: 0,
      sale_price: 0,
      stock_status: '',
      featured: true,
      has_stock: true,
      quantity: 0,
      images: '',
      image: '',
      brand_id: 0,
      category_id: 0,
      SKU: '',
      seller_id: 0,
      category: {
        id: 1,
        name: 'cat 1',
        slug: '',
        image: '',
        parent_id: 0
      },
      brand: {
        id: 1,
        name: 'brand 1',
        slug: '',
        image: '',
        products: 0
      }
    },
    {
      id: 4, name: 'Category 1', slug: 'category-4',
      short_description: '',
      description: '',
      regular_price: 0,
      sale_price: 0,
      stock_status: '',
      featured: true,
      has_stock: true,
      quantity: 0,
      images: '',
      image: '',
      brand_id: 0,
      category_id: 0,
      SKU: '',
      seller_id: 0,
      category: {
        id: 1,
        name: 'cat 1',
        slug: '',
        image: '',
        parent_id: 0
      },
      brand: {
        id: 1,
        name: 'brand 1',
        slug: '',
        image: '',
        products: 0
      }
    },
    {
      id: 5, name: 'Category 1', slug: 'category-5',
      short_description: '',
      description: '',
      regular_price: 0,
      sale_price: 0,
      stock_status: '',
      featured: true,
      has_stock: true,
      quantity: 0,
      images: '',
      image: '',
      brand_id: 0,
      category_id: 0,
      SKU: '',
      seller_id: 0,
      category: {
        id: 1,
        name: 'cat 1',
        slug: '',
        image: '',
        parent_id: 0
      },
      brand: {
        id: 1,
        name: 'brand 1',
        slug: '',
        image: '',
        products: 0
      }
    },
  ]

  constructor(private httpclient: HttpClient) { }

  getData(){
    return of(this.products)
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
