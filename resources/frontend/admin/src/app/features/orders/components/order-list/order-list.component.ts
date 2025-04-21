import {Component, inject, OnInit, Renderer2} from '@angular/core';
import {Config} from 'datatables.net';
import {OrderStore} from '../../../../store/orders/list.store';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-order-list',
  standalone: false,
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.scss'
})
export class OrderListComponent implements OnInit{
  dtOptions: Config = {};
  sortBy: string = 'id'
  sortAsc: boolean = true

  private _store: OrderStore = inject(OrderStore)
  vm$ = this._store.vm$

  constructor(
    private renderer: Renderer2
  ){}

  ngOnInit(): void {
    this._store.loadData(defaultPaging);
  }

  pageChanged(event: FilterModel) {
    this.sortBy = event.sortBy
    this.sortAsc = event.sortAsc
    const startIndex = (event.page - 1) * event.limit
    const endIndex = event.page * event.limit

    this._store.loadData(event);
  }

  reload() {
    this._store.loadData(defaultPaging);
  }
}
