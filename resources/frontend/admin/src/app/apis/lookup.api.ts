import {Injectable} from '@angular/core';
import {of, throwError} from 'rxjs';
import {formatDate} from '@angular/common';
import {Order} from '../types/orders/order';
import {HttpErrorResponse} from '@angular/common/http';
import {MODULE} from './order.api';
import {BaseHttpClient} from './base.http-client';
import {FilterModel} from '../types/filter.model';

@Injectable({
  providedIn: 'root'
})
export class LookupApi {

  constructor(private baseHttpClient: BaseHttpClient) {
  }

  getCouriers(countryId: number | undefined) {
    return countryId !== undefined ? this.baseHttpClient.getAll(`lookup/couriers/${countryId}`) : this.baseHttpClient.getAll(`lookup/couriers`);
  }

   getCountries() {
    alert('mike')
    return this.baseHttpClient.getAll(`lookup/countries`);
  }

  getBrands() {
    return this.baseHttpClient.getAll('lookup/brands');
  }

  getOrders() {
    return this.baseHttpClient.getAll('lookup/orders');
  }

  getCategories() {
    return this.baseHttpClient.getAll('lookup/categories');
  }

  getAttributes() {
    return this.baseHttpClient.getAll('lookup/attributes');
  }

  getAttributesForCategory(categoryId: number) {
    return this.baseHttpClient.getAll(`lookup/attributes/${categoryId}`);
  }

  getSubcategories(category_id: number) {
    return this.baseHttpClient.getAll(`lookup/subcategories/${category_id}`);
  }
}
