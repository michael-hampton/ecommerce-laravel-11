import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Subscription} from "rxjs";
import {ModalService} from "../../../../services/modal.service";
import {UserStore} from '../../../../store/users/list.store';
import {ModalComponent} from "../../../../shared/components/modal/modal.component";
import {FormComponent} from '../form/form.component';
import { FilterModel } from '../../../../types/filter.model';

@Component({
  selector: 'app-user-list',
  standalone: false,
  templateUrl: './user-list.component.html',
  styleUrl: './user-list.component.scss',
  providers: [UserStore]
})
export class UserListComponent implements OnInit {
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: UserStore = inject(UserStore)
  vm$ = this._store.vm$

  constructor(
    private modalService: ModalService,
  ) {
  }

  ngOnInit(): void {
    this._store.loadData(this._store.filter$);
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, data, {modalTitle: 'Edit User'})
      .subscribe((v) => {
        this._store.reset();
      });
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

  makeActive(data: any) {
    const message = data.active ? 'This will prevent the user from being able to log in. They will no longer be able to access their account' : 'This will mean the user can log in and access their account'
    const saveButtonText = data.active ? 'Hide' : 'Publish'
    this.sub = this.modalService
    .openConfirmationModal(ModalComponent, this.entry, data, {modalTitle: 'Are you sure?', modalBody: message, saveButtonLabel: saveButtonText})
    .subscribe((v) => {
      this._store.makeActive(data).subscribe()
    });
  }

  add(event: Event) {
    event.preventDefault()
    this.sub = this.modalService
      .openModal(FormComponent, this.entry, null, {modalTitle: 'Create User'})
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
