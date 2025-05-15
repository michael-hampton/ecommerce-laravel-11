import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Subscription } from 'rxjs';
import { ModalService } from '../../../../services/modal.service';
import { ProductStore } from "../../../../store/products/list.store";
import { ModalComponent } from "../../../../shared/components/modal/modal.component";
import { ProductFormComponent } from '../../../../shared/components/product-form/product-form.component';
import { defaultPaging, FilterModel } from '../../../../types/filter.model';
import { GlobalStore } from '../../../../store/global.store';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-product-list',
  standalone: false,
  templateUrl: './product-list.component.html',
  styleUrl: './product-list.component.scss',
  providers: [ProductStore]
})
export class ProductListComponent implements OnInit {
  @ViewChild('modal', { read: ViewContainerRef })
  entry!: ViewContainerRef;
  sub!: Subscription;
  activeTab = ''

  private _store: ProductStore = inject(ProductStore)
  vm$ = this._store.vm$

  private _globalStore = inject(GlobalStore)
  globalvm$ = this._globalStore.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(ProductFormComponent, data, { modalTitle: 'Edit Product' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal({
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close',
        //size: 'modal-sm'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(ProductFormComponent, null, { modalTitle: 'Create Product' })
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
    const message = data.active ? 'This will hide the product from everywhere in the website' : 'This will show the product in all relevant places'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.sub = this.modalService
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText })
      .subscribe((v) => {
        this._store.makeActive(data).subscribe()
      });
  }

  filterChanged(column: string, value: string) {
    this.activeTab = value === this.activeTab ? '' : value
    const searchFilters = []
    searchFilters.push({
      column: column,
      value: this.activeTab === '' ? undefined : this.activeTab === 'published' ? true : false,
      operator: '='
    })
    const obj: FilterModel = { ...defaultPaging, ...{ searchFilters: searchFilters } }

    this._store.updateFilter(obj)
  }
}
