import { Component, inject, OnInit, Renderer2 } from '@angular/core';
import { Config } from 'datatables.net';
import { OrderStore } from '../../../../store/orders/list.store';
import { defaultPaging, FilterModel, SearchFilter } from '../../../../types/filter.model';
import { CategoryStore } from '../../../../store/categories/list.store';
import { OrderStatusEnum } from '../../../../types/orders/orderStatus.enum';
import { Order } from '../../../../types/orders/order';
import { OrderDetail } from '../../../../types/orders/order-detail';

@Component({
  selector: 'app-order-list',
  standalone: false,
  templateUrl: './order-list.component.html',
  styleUrl: './order-list.component.scss',
  providers: [OrderStore]
})
export class OrderListComponent implements OnInit {

  private _store: OrderStore = inject(OrderStore)
  vm$ = this._store.vm$
  currentTab: string;

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
    this._store.filter$.subscribe(result => {
      console.log('filter', result.searchFilters)
    })
  }

  pageChanged(filter: FilterModel) {
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset();
  }

  orderHasIssue(order: Order) {
    return order?.orderItems?.some(x => ['refund_requested', 'issue_reported'].includes(x.status))
  }

  filterChanged(column: string, value: string) {
    this.currentTab = value === this.currentTab ? '' : value
    const searchFilters = []
    searchFilters.push({
      column: column,
      value: this.currentTab === '' ? undefined : this.currentTab,
      operator: '='
    })
    const obj: FilterModel = { ...defaultPaging, ...{ searchFilters: searchFilters, sortBy: 'id', sortDir: 'desc' } }

    this._store.updateFilter(obj)
  }

  protected readonly OrderStatusEnum = OrderStatusEnum;
}
