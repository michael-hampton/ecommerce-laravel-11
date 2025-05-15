import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { AttributeValueStore } from '../../../../store/attribute-values/list.store';
import { ModalService } from '../../../../services/modal.service';
import { FormComponent } from '../form/form.component';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-attribute-value-list',
  standalone: false,
  templateUrl: './attribute-value-list.component.html',
  styleUrl: './attribute-value-list.component.scss',
  providers: [AttributeValueStore]
})
export class AttributeValueListComponent implements OnInit {
  dtOptions: Config = {};

  private _store: AttributeValueStore = inject(AttributeValueStore)
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

  add(event: Event) {
    event.preventDefault()
    this.modalService
      .openModal(FormComponent, null, { modalTitle: 'Create Attribute Value' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.modalService
      .openModal(FormComponent, data, { modalTitle: 'Edit Attribute Value' })
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
    this._store.reset()
  }
}
