import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { ModalService } from '../../../../services/modal.service';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { defaultPaging, FilterModel } from '../../../../types/filter.model';
import { SellerStore } from '../../../../store/sellers/list.store';
import { Seller } from '../../../../types/seller/seller';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-list',
  standalone: false,
  templateUrl: './list.component.html',
  styleUrl: './list.component.scss',
  providers: [SellerStore]
})
export class ListComponent implements OnInit {

  private _store: SellerStore = inject(SellerStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  makeActive(data: any) {
    const message = data.active ? 'This will prevent the seller from being able to log in. They will no longer be able to access their account including adding new listings and managing their orders' : 'This will mean the seller can log in and access their account including adding new listings and managing their orders'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.modalService
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText })
      .subscribe((v) => {
        this._store.makeActive(data.active !== true, data).subscribe()
      });
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

  /*add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Seller'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Seller'})
      .subscribe((v) => {
        this._store.reset();
      });
  }*/

  pageChanged(filter: FilterModel) {
    const searchFilters = []
    searchFilters.push({
      column: 'name',
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
