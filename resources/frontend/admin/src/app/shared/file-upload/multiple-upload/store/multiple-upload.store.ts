import { Injectable } from '@angular/core';
import { ComponentStore } from '@ngrx/component-store';

export interface MultipleUploadStoreState {
    selectedFiles?: FileList;
    previews?: string[];
}

const defaultState: MultipleUploadStoreState = {
    previews: []

};

@Injectable()
export class MultipleUploadStore extends ComponentStore<MultipleUploadStoreState> {
    constructor() {
        super(defaultState);
    }

    readonly files$ = this.select(state => state.selectedFiles);
    readonly galleryImages$ = this.select(({ previews }) => previews);

    vm$ = this.select(state => ({
        selectedFiles: state.selectedFiles
    }))

    doUpload(selectedFiles: FileList) {
        this.patchState({ selectedFiles: selectedFiles })

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

            this.patchState({ previews: previews })
        }
    }

    bulkUpload(event: any): void {
        const selectedFiles = event.target.files
        this.doUpload(selectedFiles)
    }

    readonly updateImageGallery = this.updater((state, previews: string[]) => ({
        ...state,
        previews: previews
    }));

    readonly updateFiles = this.updater((state, selectedFiles: FileList) => ({
        ...state,
        selectedFiles: selectedFiles
    }));
}
