import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {delay, Observable, of} from 'rxjs';
import {Product} from "../types/products/product";
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';

export const MODULE = 'admin/products'

@Injectable({
  providedIn: 'root'
})
export class ProductApi {

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
      SKU: 'test',
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
      SKU: 'test',
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
      SKU: 'test',
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
      SKU: 'test',
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
      SKU: 'test',
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
      id: 6, name: 'Category 1', slug: 'category-1',
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
      SKU: 'test',
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
      id: 7, name: 'Category 1', slug: 'category-2',
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
      SKU: 'test',
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
      id: 8, name: 'Category 1', slug: 'category-3',
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
      SKU: 'test',
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
      id: 9, name: 'Category 1', slug: 'category-4',
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
      SKU: 'test',
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
      id: 10, name: 'Category 1', slug: 'category-5',
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
      SKU: 'test',
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
      id: 11, name: 'Category 1', slug: 'category-1',
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
      SKU: 'test',
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
      id: 12, name: 'Category 1', slug: 'category-2',
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
      SKU: 'test',
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
      id: 13, name: 'Category 1', slug: 'category-3',
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
      SKU: 'test',
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
      id: 14, name: 'Category 1', slug: 'category-4',
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
      SKU: 'test',
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
      id: 15, name: 'Category 1', slug: 'category-5',
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
      SKU: 'test',
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
      id: 16, name: 'Category 1', slug: 'category-1',
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
      SKU: 'test',
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
      id: 17, name: 'Category 1', slug: 'category-2',
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
      SKU: 'test',
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
      id: 18, name: 'Category 1', slug: 'category-3',
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
      SKU: 'test',
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
      id: 19, name: 'Category 1', slug: 'category-4',
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
      SKU: 'test',
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
      id: 20, name: 'Category 1', slug: 'category-5',
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
      SKU: 'test',
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

  delete(id: number) {
    alert('deleting')
    return of(this.products);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Product>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Product>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<PagedData<Product>>{
    return of({data: this.products, page: 1, totalCount: this.products.length} as PagedData<Product>).pipe(delay(3000))

    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
