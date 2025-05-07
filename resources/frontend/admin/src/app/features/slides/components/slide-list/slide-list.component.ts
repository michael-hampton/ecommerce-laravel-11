import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from "datatables.net";
import {Subscription} from "rxjs";
import {ModalService} from "../../../../services/modal.service";
import {SlideStore} from "../../../../store/slides/list.store";
import {ModalComponent} from '../../../../shared/components/modal/modal.component';
import {FormComponent} from '../form/form.component';
import {defaultPaging, FilterModel} from '../../../../types/filter.model';
import {CategoryStore} from '../../../../store/categories/list.store';

@Component({
  selector: 'app-slide-list',
  standalone: false,
  templateUrl: './slide-list.component.html',
  styleUrl: './slide-list.component.scss',
  providers: [SlideStore]
})
export class SlideListComponent implements OnInit {
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

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
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit Slide'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create Slide'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  pageChanged(filter: FilterModel) {
    console.log('filter', filter)
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset();
  }

  makeActive(data: any) {
    const message = data.active ? 'This will hide the slide from the banner on the homepage.' : 'This will show the slide in the banner on the homepage'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.sub = this.modalService
    .openConfirmationModal(ModalComponent, this.entry, data, {modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText})
    .subscribe((v) => {
      this._store.makeActive(data).subscribe()
    });
  }
}

