import {Component, inject, OnInit} from '@angular/core';
import {DashboardStore} from '../../../../store/dashboard/list.store';
import {LookupStore} from "../../../../store/lookup.store";

@Component({
  selector: 'app-dashboard-page',
  standalone: false,
  templateUrl: './dashboard-page.component.html',
  styleUrl: './dashboard-page.component.scss',
  providers: [DashboardStore]
})
export class DashboardPageComponent implements OnInit{

  private _store: DashboardStore = inject(DashboardStore);
  vm$ = this._store.vm$

  private _lookupStore: LookupStore = inject(LookupStore);
  lookupVm$ = this._lookupStore.vm$

  constructor() {
  }

  ngOnInit() {
    this._store.getData();
    this._lookupStore.getOrders();
  }
}
