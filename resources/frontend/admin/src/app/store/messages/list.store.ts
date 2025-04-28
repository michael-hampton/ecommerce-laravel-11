import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';
import {Observable, switchMap, tap} from 'rxjs';
import {tapResponse} from '@ngrx/operators'
import {GlobalStore} from "../global.store";
import {UiError} from '../../core/services/exception.service';
import {defaultPaging, FilterModel, FilterState, PagedData} from '../../types/filter.model';
import {MessageApi} from '../../apis/message.api';
import {Message, SaveMessage} from '../../types/messages/message';
import {ComponentStore} from '@ngrx/component-store';

type MessageState = FilterState<Message> & {
  message: Message,
  loading: boolean,
  selectedFiles?: FileList;
  previews?: string[];
}

const defaultState: MessageState = {
  data: {} as PagedData<Message>,
  filter: {...defaultPaging, ...{sortBy: 'created_at', sortAsc: false}},
  message: {} as Message,
  loading: false,
  previews: []
};

@Injectable()
export class MessageStore extends ComponentStore<MessageState> {
  constructor(private _api: MessageApi, private _globalStore: GlobalStore) {
    super(defaultState);
  }

  readonly data$ = this.select(({data}) => data);
  readonly message$ = this.select(({message}) => message);
  readonly filter$ = this.select(({filter}) => filter);
  readonly files$ = this.select(state => state.selectedFiles);
  readonly galleryImages$ = this.select(({previews}) => previews);

  readonly vm$ = this.select(
    {
      data: this.data$,
      message: this.message$
    },
    {debounce: true}
  );

  createReply = (payload: Partial<SaveMessage>) => {

    return this._api.create(payload).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: (users) => {
          this._globalStore.setSuccess('Saved successfully');
          //this.patchState({loading: false, saveSuccess: true})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  loadData = this.effect((filter$: Observable<FilterModel>) =>
    filter$.pipe(
      tap(() => this._globalStore.setLoading(true)),
      switchMap((filter: FilterModel) => this._api.getData(filter).pipe(
          tapResponse({
            next: (data) => this.patchState({data: data as PagedData<Message>}),
            error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
            complete: () => this._globalStore.setLoading(false)
          })
        )
      )
    )
  );

  getMessageDetails(messageId: number) {
    return this._api.getMessageDetails(messageId).pipe(
      tap(() => this.patchState({loading: true})),
      tapResponse({
        next: (message: Message) => {
          console.log('message', message)
          this.patchState({message: message as Message})
        },
        error: (error: HttpErrorResponse) => {
          this._globalStore.setError(UiError(error))
        },
        complete: () => this.patchState({loading: false}),
      })
    )
  }

  updatePage(page: number) {
    this.patchState({filter: {...defaultPaging, ...{page: page, sortBy: 'created_at', sortAsc: false,}}})
  }

  bulkUpload(event: any): void {
    const selectedFiles = event.target.files
    this.patchState({selectedFiles: selectedFiles})

    let previews = [];
    if (selectedFiles && selectedFiles[0]) {
      const numberOfFiles = selectedFiles.length;
      for (let i = 0; i < numberOfFiles; i++) {
        const reader = new FileReader();

        reader.onload = (e: any) => {
          console.log(e.target.result);
          previews.push(e.target.result);
        };

        reader.readAsDataURL(selectedFiles[i]);
      }

      this.patchState({previews: previews})
    }
  }
}
