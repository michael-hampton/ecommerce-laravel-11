import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Subscription } from "rxjs";
import { ModalService } from "../../../../services/modal.service";
import { SlideStore } from "../../../../store/slides/list.store";
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { FormComponent } from '../form/form.component';
import { FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-slide-list',
  standalone: false,
  templateUrl: './slide-list.component.html',
  styleUrl: './slide-list.component.scss',
  providers: [SlideStore]
})
export class SlideListComponent implements OnInit {

  private _store: SlideStore = inject(SlideStore)
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
      .openModal(FormComponent, data, { modalTitle: 'Edit Slide' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.modalService
      .openModal(FormComponent, null, { modalTitle: 'Create Slide' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  pageChanged(filter: FilterModel) {
      const searchFilters = []
      searchFilters.push({
        column: 'title',
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
    const message = data.active ? 'This will hide the slide from the banner on the homepage.' : 'This will show the slide in the banner on the homepage'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.modalService
      .openConfirmationModal({ modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText })
      .subscribe((v) => {
        this._store.makeActive(data).subscribe()
      });
  }
}

