import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { MultipleUploadStore } from './store/multiple-upload.store';

@Component({
  selector: 'app-multiple-upload',
  standalone: false,
  templateUrl: './multiple-upload.component.html',
  styleUrl: './multiple-upload.component.scss',
  providers: [MultipleUploadStore]
})
export class MultipleUploadComponent {
  _store = inject(MultipleUploadStore)
  @Output() fileUploadHandler = new EventEmitter()
  @Input() files?: string[]

  ngOnInit() {
    this._store.files$.subscribe(files => {
      this.fileUploadHandler.emit(files)
    })

    this._store.updateImageGallery(this.files)
  }
}
