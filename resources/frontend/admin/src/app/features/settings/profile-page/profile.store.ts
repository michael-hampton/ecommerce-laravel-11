import { HttpErrorResponse } from "@angular/common/http";
import { Injectable } from "@angular/core";
import { ComponentStore } from "@ngrx/component-store";
import { tapResponse } from "@ngrx/operators";
import { tap } from "rxjs";
import { Seller } from "../../../types/seller/seller";
import { SellerApi } from "../../../apis/seller.api";
import { GlobalStore } from "../../../store/global.store";
import { UiError } from "../../../core/error.model";
import { AuthService } from "../../../core/auth/auth.service";

export interface ProfileState {
    data: Seller
    loading: boolean,
    imagePreview: string,
    currentFile?: File
}

const defaultState: ProfileState = {
    imagePreview: '',
    currentFile: undefined,
    data: {} as Seller,
    loading: false,
};

@Injectable()
export class ProfileStore extends ComponentStore<ProfileState> {
    constructor(private _api: SellerApi, private _globalStore: GlobalStore, private _authService: AuthService) {
        super(defaultState);
    }

    readonly data$ = this.select(({ data }) => data);
    readonly currentFile$ = this.select(({ currentFile }) => currentFile);

    vm$ = this.select(state => ({
        data: state.data,
        loading: state.loading,
        imagePreview: state.imagePreview,
    }))

    getData(sellerId: number) {
        this.patchState({ loading: true })
        return this._api.getSeller(sellerId).pipe(
            tapResponse({
                next: (data) => {
                    this.patchState({ data: data as Seller })
                },
                error: (error: HttpErrorResponse) => this._globalStore.setError(UiError(error)),
                finalize: () => this.patchState({ loading: false }),
            })
        )
    }

    saveData = (payload: any, id: number) => {
        const request$ = id ? this._api.updateImage(id, payload) : this._api.create(payload)

        return request$.pipe(
            tap(() => this._globalStore.setLoading(true)),
            tapResponse({
                next: (response: any) => {
                    this.updateProfileImage(response.data.profile_picture)
                    this._globalStore.setSuccess('Saved successfully')
                },
                error: (error: HttpErrorResponse) => {
                    this._globalStore.setLoading(false)
                    this._globalStore.setError(UiError(error))
                },
                finalize: () => this._globalStore.setLoading(false),
            })
        )
    }

    selectFile(event: any): void {
        this.patchState({ imagePreview: '' })
        const selectedFiles = event.target.files;

        if (selectedFiles) {
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
    }

    updateProfileImage(image: string) {
        const user = this._authService.GetUser()
        user.payload.image = image
        this._authService.SetLocalSession(user)
    }
}