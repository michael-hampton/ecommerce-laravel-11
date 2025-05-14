import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import {ModalService} from '../../../../services/modal.service';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import { defaultPaging, FilterModel} from '../../../../types/filter.model';
import { CourierStore } from '../../../../store/couriers/list.store';
import { LookupStore } from '../../../../store/lookup.store';

@Component({
  selector: 'app-courier-list',
  standalone: false,
  templateUrl: './courier-list.component.html',
  styleUrl: './courier-list.component.scss',
  providers: [CourierStore]
})
export class CourierListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: CourierStore = inject(CourierStore)
  vm$ = this._store.vm$
  private _lookupStore = inject(LookupStore)
  lookupVm$ = this._lookupStore.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
    this._lookupStore.getCountries()
  }

  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal(ModalComponent, this.entry, data, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
        this._store.reset();
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Courier'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Courier'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  pageChanged(filter: FilterModel) {
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset();
  }

  filterSelectChanged(event: Event) {
    const el = (event.currentTarget) as HTMLInputElement
    const searchFilters = []
    searchFilters.push({
      column: el.name,
      value: el.value,
      operator: '='
    })
    const obj: FilterModel = {...defaultPaging, ...{searchFilters: searchFilters}}
    
    this._store.updateFilter(obj)
  }
}
