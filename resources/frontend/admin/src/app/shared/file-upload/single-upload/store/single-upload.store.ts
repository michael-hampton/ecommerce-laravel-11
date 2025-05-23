import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';

export interface SingleUploadStoreState {
    imagePreview: string;
    currentFile?: File;
}

const defaultState: SingleUploadStoreState = {
    imagePreview: '',
    currentFile: undefined,

};

@Injectable()
export class SingleUploadStore extends ComponentStore<SingleUploadStoreState> {
    constructor() {
        super(defaultState);
    }

    readonly file$ = this.select(state => state.currentFile);
    readonly image$ = this.select(({ imagePreview }) => imagePreview);

    vm$ = this.select(state => ({
        imagePreview: state.imagePreview,
    }))

    doUpload(selectedFiles: FileList) {
        if (!selectedFiles) {
            return
        }

        this.patchState({ imagePreview: '' })
        const file: File | null = selectedFiles.item(0);

        if (file) {
            this.patchState({ imagePreview: '', currentFile: file })

            const reader = new FileReader();

            reader.onload = (e: any) => {
                this.patchState({ imagePreview: e.target.result })

            };

            reader.readAsDataURL(file);
        }
    }

    selectFile(event: any): void {
        const selectedFiles = event.target.files;

        this.doUpload(selectedFiles)
    }

    readonly updateImagePreview = this.updater((state, imagePreview: string) => ({
        ...state,
        imagePreview: imagePreview
    }));

    readonly updateFile = this.updater((state, currentFile: File) => ({
        ...state,
        currentFile: currentFile
    }));
}
