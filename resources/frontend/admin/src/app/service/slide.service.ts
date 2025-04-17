import { Injectable } from '@angular/core';
import {HttpClient} from '@angular/common/http';
import {BASE_URL} from '../config';
import {of} from 'rxjs';
import {Slide} from '../data/slide';

export const MODULE = 'admin/slides'

@Injectable({
  providedIn: 'root'
})
export class SlideService {

  private slides: Slide[] = [
    {
      id: 1, title: 'Category 1', subtitle: 'category-1',
      image: '',
      link: '',
      tags: '',
      active: false,
      link_text: ''
    },
    {
      id: 2, title: 'Category 1', subtitle: 'category-2',
      image: '',
      link: '',
      tags: '',
      active: false,
      link_text: ''
    },
    {
      id: 3, title: 'Category 1', subtitle: 'category-3',
      image: '',
      link: '',
      tags: '',
      active: false,
      link_text: ''
    },
    {
      id: 4, title: 'Category 1', subtitle: 'category-4',
      image: '',
      link: '',
      tags: '',
      active: false,
      link_text: ''
    },
    {
      id: 5, title: 'Category 1', subtitle: 'category-5',
      image: '',
      link: '',
      tags: '',
      active: false,
      link_text: ''
    },
  ]

  constructor(private httpclient: HttpClient) { }

  getData(){
    return of(this.slides)
    //return this.httpclient.get(`${BASE_URL}/${MODULE}`);
  }
}
