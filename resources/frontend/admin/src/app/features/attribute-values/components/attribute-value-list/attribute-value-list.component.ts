import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import {AttributeValueStore} from '../../../../store/attribute-values/list.store';
import {ModalService} from '../../../../services/modal.service';
import {FormComponent} from '../form/form.component';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-attribute-value-list',
  standalone: false,
  templateUrl: './attribute-value-list.component.html',
  styleUrl: './attribute-value-list.component.scss'
})
export class AttributeValueListComponent implements OnInit {
  dtOptions: Config = {};

  @ViewChild('confirmationModal', {read: ViewContainerRef})
  deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;
  sortBy: string = 'name'
  sortAsc: boolean = true

  private _store: AttributeValueStore = inject(AttributeValueStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(defaultPaging);
  }

  delete = async (data: any) => {
    this.sub = this.modalService
      .openConfirmationModal(ModalComponent, this.deleteModalComponent, data, {
        modalTitle: 'Are you sure?',
        modalBody: 'click confirm or close'
      })
      .subscribe((v) => {
        this._store.delete(data.id)
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Attribute Value'})
      .subscribe((v) => {
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Attribute Value'})
      .subscribe((v) => {
      });
  }

  pageChanged(event: FilterModel) {
    this.sortBy = event.sortBy
    this.sortAsc = event.sortAsc
    const startIndex = (event.page - 1) * event.limit
    const endIndex = event.page * event.limit

    this._store.loadData(event);
  }

  reload() {
    this._store.loadData(defaultPaging);
  }
}
