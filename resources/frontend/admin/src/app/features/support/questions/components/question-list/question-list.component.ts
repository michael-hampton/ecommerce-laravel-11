import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import { SupportQuestionStore } from '../../../../../store/support/questions/list.store';
import { ModalService } from '../../../../../services/modal.service';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { FilterModel } from '../../../../../types/filter.model';
import { QuestionFormComponent } from '../question-form/question-form.component';

@Component({
  selector: 'app-question-list',
  standalone: false,
  templateUrl: './question-list.component.html',
  styleUrl: './question-list.component.scss',
  providers: [SupportQuestionStore]
})
export class QuestionListComponent implements OnInit {
  dtOptions: Config = {};

  @ViewChild('confirmationModal', {read: ViewContainerRef})
  deleteModalComponent!: ViewContainerRef;
  @ViewChild('modal', {read: ViewContainerRef})
  entry!: ViewContainerRef;
  sub!: Subscription;

  private _store: SupportQuestionStore = inject(SupportQuestionStore)
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
      .openConfirmationModal(ModalComponent, this.deleteModalComponent, data, {
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
      .openModal(QuestionFormComponent, this.entry, null, {modalTitle: 'Create Question'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.sub = this.modalService
      .openModal(QuestionFormComponent, this.entry, data, {modalTitle: 'Edit Question'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  pageChanged(filter: FilterModel) {
    this._store.updateFilter(filter)
  }

  reload() {
    this._store.reset()
  }
}
