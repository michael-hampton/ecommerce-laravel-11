import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import {ModalService} from '../../../../services/modal.service';
import {AttributeStore} from '../../../../store/attributes/list.store';
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';
import {AttributeValueStore} from '../../../../store/attribute-values/list.store';

@Component({
  selector: 'app-attribute-list',
  standalone: false,
  templateUrl: './attribute-list.component.html',
  styleUrl: './attribute-list.component.scss',
  providers: [AttributeStore]
})
export class AttributeListComponent implements OnInit {
  dtOptions: Config = {};
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: AttributeStore = inject(AttributeStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
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

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Attribute'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Attribute'})
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
}
