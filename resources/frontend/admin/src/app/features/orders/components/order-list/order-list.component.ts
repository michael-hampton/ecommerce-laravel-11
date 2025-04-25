import {Component, inject, OnInit, Renderer2} from '@angular/core';
import {Config} from 'datatables.net';
import {OrderStore} from '../../../../store/orders/list.store';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-order-list',
  standalone: false,
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.scss',
  providers: [OrderStore]
})
export class OrderListComponent implements OnInit{

  private _store: OrderStore = inject(OrderStore)
  vm$ = this._store.vm$

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  pageChanged(filter: FilterModel) {
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset();
  }
}
