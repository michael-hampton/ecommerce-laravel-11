import { Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef } from '@angular/core';
import { Config } from 'datatables.net';
import { Subscription } from 'rxjs';
import { SupportQuestionStore } from '../../../../../store/support/questions/list.store';
import { ModalService } from '../../../../../services/modal.service';
import { ModalComponent } from '../../../../../shared/components/modal/modal.component';
import { FilterModel } from '../../../../../types/filter.model';
import { QuestionFormComponent } from '../question-form/question-form.component';
import { formatSearchText } from '../../../../../core/common';

@Component({
  selector: 'app-question-list',
  standalone: false,
  templateUrl: './question-list.component.html',
  styleUrl: './question-list.component.scss',
  providers: [SupportQuestionStore]
})
export class QuestionListComponent implements OnInit {

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
      .openModal(QuestionFormComponent, null, { modalTitle: 'Create Question' })
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.modalService
      .openModal(QuestionFormComponent, data, { modalTitle: 'Edit Question' })
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
