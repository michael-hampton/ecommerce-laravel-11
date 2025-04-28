import {Injectable} from '@angular/core';
import {Observable, of} from 'rxjs';
import {Shipping} from "../types/shipping/shipping";
import {FilterModel, PagedData} from '../types/filter.model';
import {BaseHttpClient} from './base.http-client';
import {environment} from '../../environments/environment';
import {HttpClient} from '@angular/common/http';
import {Country} from '../types/countries/country';

export const MODULE = 'shipping'

@Injectable({
  providedIn: 'root'
})
export class ShippingApi {

  constructor(private baseHttpClient: BaseHttpClient, private httpClient: HttpClient) {
  }

  create(payload: Partial<Shipping>) {
    return this.httpClient.post(`${environment.apiUrl}/${MODULE}`, payload);
  }

  getCouriers() {
    const data = {
      data: [
        {id: 1, name: 'Test 1', active: true},
        {id: 2, name: 'Test 2', active: true},
        {id: 3, name: 'Test 3', active: true},
        {id: 4, name: 'Test 4', active: true}
      ]
    }

    return of(data)
  }

  getDataForCountry(countryId: number) {
    const data: Shipping[] = [
      {
        courier_id: 1,
        name: 'Large',
        price: 12.99,
        tracking: true,
        country_id: 422
      },
      {
        courier_id: 2,
        name: 'Large',
        price: 12.99,
        tracking: true,
        country_id: 422
      },
      {
        courier_id: 2,
        name: 'Medium',
        price: 12.99,
        tracking: true,
        country_id: 422
      },
      {
        courier_id: 3,
        name: 'Small',
        price: 12.99,
        tracking: true,
        country_id: 422
      },
      {
        courier_id: 4,
        name: 'Medium',
        price: 12.99,
        tracking: true,
        country_id: 422
      }
    ];

    return of(data)
  }

  getData(filter: FilterModel) {
    const data: PagedData<Country> = {
      current_page: 1,
      total: 10,
      per_page: 10,
      data: [
        {
          name: 'United States',
          code: 'USA',
          id: 1
        },
        {
          name: 'United Kingdom',
          code: 'UK',
          id: 2
        }
      ]};

    return of(data)
  }

  update(id: number, payload: Partial<Shipping>) {
    return this.httpClient.put(`${environment.apiUrl}/${MODULE}/${id}`, payload);
  }

  delete(id: number) {
    return this.httpClient.delete(`${environment.apiUrl}/${MODULE}/${id}`)
  }
}
