import {Injectable} from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {Observable, of} from 'rxjs';
import {Attribute} from '../types/attributes/attribute';
import {FilterModel, PagedData} from '../types/filter.model';
import {Category} from '../types/categories/category';
import {User} from '../types/users/user';
import {BaseHttpClient} from './base.http-client';

export const MODULE = 'attributes'

@Injectable({
  providedIn: 'root'
})
export class AttributeApi {

  private attributes: Attribute[] = [
    {
      id: 1, name: 'Color', attribute_values: [{
        id: 3,
        name: 'test 4',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 1,
        name: 'test 1',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 1,
        name: 'test 2',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }]
    },
    {
      id: 2, name: 'Size', attribute_values: [{
        id: 10,
        name: 'test 10',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 9,
        name: 'test 9',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 8,
        name: 'test 8',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }]
    },
    {
      id: 3, name: 'Package Size', attribute_values: [{
        id: 5,
        name: 'test 6',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 1,
        name: 'test 1',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 2,
        name: 'test 2',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }]
    },
    {
      id: 4, name: 'Condition', attribute_values: [{
        id: 3,
        name: 'test 3',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 4,
        name: 'test 4',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }, {
        id: 5,
        name: 'test 5',
        attribute_id: 0,
        attribute: {
          id: 0,
          name: '',
          attribute_values: undefined
        }
      }]
    }
  ]

  constructor(private baseHttpClient: BaseHttpClient) { }

  delete(id: number) {
    alert('deleting')
    return of(this.attributes);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  create(payload: Partial<Attribute>) {
    alert('creating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  update(id: number, payload: Partial<Attribute>) {
    alert('updating')
    return of(payload);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }

  getData(filter: FilterModel): Observable<any> {
    return this.baseHttpClient.get(filter, MODULE);
    //return of({data: this.attributes, current_page: 1, total: this.attributes.length} as PagedData<Attribute>)
  }
}
