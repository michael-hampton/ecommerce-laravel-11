import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { ModalService } from '../../../../services/modal.service';
import { BrandStore } from "../../../../store/brands/list.store";
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FormComponent } from '../form/form.component';
import { FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-brand-list',
  standalone: false,
  templateUrl: './brand-list.component.html',
  styleUrl: './brand-list.component.scss',
  providers: [BrandStore]
})
export class BrandListComponent implements OnInit {

  private _store: BrandStore = inject(BrandStore)
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
      .openModal(FormComponent, data, { modalTitle: 'Edit Brand' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.modalService
      .openModal(FormComponent, null, { modalTitle: 'Create Brand' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

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

  makeActive(data: any) {
    const message = data.active ? 'This will hide the brand from the website, including the menu. Any products listed within the brand will no longer be accessible from inside the brand. They may still be accessible from any categories they are listed in' : 'This will show the brand from the website including the menu. Any products listed within the brand will become accessible from within it'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.modalService
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText })
      .subscribe((v) => {
        this._store.makeActive(data).subscribe()
      });
  }
}
