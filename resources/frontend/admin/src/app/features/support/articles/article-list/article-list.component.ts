import {Component, inject, OnInit, Renderer2, ViewChild, ViewContainerRef} from '@angular/core';
import {Config} from 'datatables.net';
import {Subscription} from 'rxjs';
import { SupportArticleStore } from '../../../../store/support/articles/list.store';
import { ModalService } from '../../../../services/modal.service';
import { ModalComponent } from '../../../../shared/components/modal/modal.component';
import { ArticleFormComponent } from '../article-form/article-form.component';
import { FilterModel } from '../../../../types/filter.model';
import { formatSearchText } from '../../../../core/common';

@Component({
  selector: 'app-article-list',
  standalone: false,
  templateUrl: './article-list.component.html',
  styleUrl: './article-list.component.scss',
   providers: [SupportArticleStore]
})
export class ArticleListComponent implements OnInit {
  private _store: SupportArticleStore = inject(SupportArticleStore)
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
      .openModal(ArticleFormComponent, null, {modalTitle: 'Create Question'})
      .subscribe((v) => {
        this._store.reset();
      });
  }

  edit(data: any) {
    this.modalService
      .openModal(ArticleFormComponent, data, {modalTitle: 'Edit Question'})
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
