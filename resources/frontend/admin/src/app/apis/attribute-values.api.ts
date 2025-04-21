import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {AttributeValue} from '../types/attribute-values/attribute-value';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';

export const MODULE = 'admin/attributeValues'

@Injectable({
  providedIn: 'root'
})
export class AttributeValuesApi {

  private attributeValues: AttributeValue[] = [
    {
      id: 1, name: 'Red', attribute_id: 1,
      attribute: {
        id: 1,
        name: 'Color'
      }
    },
    {
      id: 2, name: 'Yellow', attribute_id: 1,
      attribute: {
        id: 1,
        name: 'Color'
      }
    },
    {
      id: 3, name: 'Large', attribute_id: 2,
      attribute: {
        id: 2,
        name: 'Size'
      }
    },
    {
      id: 4, name: 'Large', attribute_id: 3,
      attribute: {
        id: 2,
        name: 'Size'
      }
    },
    {
      id: 5, name: 'New', attribute_id: 4,
      attribute: {
        id: 3,
        name: 'Condition'
      }
    },
  ]

  constructor(private httpclient: HttpClient) { }

  create(payload: Partial<AttributeValue>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<AttributeValue>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  delete(id: number){
    alert('deleting')
    return of(this.attributeValues);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<PagedData<AttributeValue>>{
    return of({data: this.attributeValues, page: 1, totalCount: this.attributeValues.length} as PagedData<AttributeValue>)
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
