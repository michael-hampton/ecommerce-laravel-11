import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';
import {of} from 'rxjs';
import {AttributeValue} from '../data/attribute-value';

export const MODULE = 'admin/attributeValues'

@Injectable({
  providedIn: 'root'
})
export class AttributeValuesService {

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

  getData(){
    return of(this.attributeValues);
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
