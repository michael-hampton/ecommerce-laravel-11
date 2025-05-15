import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { CategoryStore } from "../../../../store/categories/list.store";
import { ModalService } from "../../../../services/modal.service";
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FormComponent } from '../form/form.component';
import { defaultPaging, FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-category-list',
  standalone: false,
  templateUrl: './category-list.component.html',
  styleUrl: './category-list.component.scss',
  providers: [CategoryStore]
})
export class CategoryListComponent implements OnInit {

  private _store: CategoryStore = inject(CategoryStore)
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
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: 'click confirm or close' })
      .subscribe((v) => {
        this._store.delete(data.id)
        this._store.reset();
      });
  }

  edit(data: any) {
    this.modalService
      .openModal(FormComponent, data, { modalTitle: 'Edit Category' })
      .subscribe((v) => {
        this.modalService.closeModal();
        this._store.reset();
      });
  }

  add(event: Event) {
    this.modalService
      .openModal(FormComponent, null, { modalTitle: 'Create Category' })
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
    const message = data.active ? 'This will hide the category from the website, including the menu. Any products listed within the category will no longer be accessible' : 'This will show the category from the website including the menu. Any products listed within the category will become accessible'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.modalService
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText })
      .subscribe((v) => {
        this._store.makeActive(data).subscribe()
      });
  }
}
