import { Component, EventEmitter, inject, Input, Output } from '@angular/core';
import { SingleUploadStore } from './store/single-upload.store';

@Component({
  selector: 'app-single-upload',
  standalone: false,
  templateUrl: './single-upload.component.html',
  styleUrl: './single-upload.component.scss',
  providers: [SingleUploadStore]
})
export class SingleUploadComponent {
  _store = inject(SingleUploadStore)
  @Input() file?: string
  @Output() fileUploadHandler = new EventEmitter()

  ngOnInit() {
    this._store.file$.subscribe(file => {
      this.fileUploadHandler.emit(file)
    })

    this._store.updateImagePreview(this.file)
  }
}
