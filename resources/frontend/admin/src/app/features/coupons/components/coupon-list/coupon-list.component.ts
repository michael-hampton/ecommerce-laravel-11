import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { ModalService } from '../../../../services/modal.service';
import { CouponStore } from '../../../../store/coupons/list.store';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FormComponent } from '../form/form.component';
import { defaultPaging, FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-coupon-list',
  standalone: false,
  templateUrl: './coupon-list.component.html',
  styleUrl: './coupon-list.component.scss',
  providers: [CouponStore]
})
export class CouponListComponent implements OnInit {

  private _store: CouponStore = inject(CouponStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  delete = async (data: any) => {
    this.modalService
      .openConfirmationModal({
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
        this._store.reset();
      });
  }

  edit(data: any) {
    this.modalService
      .openModal(FormComponent, data, { modalTitle: 'Edit Coupon' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.modalService
      .openModal(FormComponent, null, { modalTitle: 'Create Coupon' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  pageChanged(filter: FilterModel) {
    const searchFilters = []
    searchFilters.push({
      column: 'code',
      value: formatSearchText(filter),
      operator: 'like'
    })
    filter = { ...filter, ...{ searchFilters: searchFilters } }

    this._store.updateFilter(filter)

  }

  reload() {
    this._store.reset();
  }
}
