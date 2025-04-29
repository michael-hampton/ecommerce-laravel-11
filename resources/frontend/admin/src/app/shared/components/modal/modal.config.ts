import { ElementRef, TemplateRef } from "@angular/core"

export interface ModalConfig {
  modalTitle: string
  modalBody?: string
  template?: TemplateRef<any>
  saveButtonLabel?: string
  showFooter?: boolean
  closeButtonLabel?: string
  size?: string;
  shouldClose?(): Promise<boolean> | boolean
  shouldSave?(): Promise<boolean> | boolean
  onClose?(): Promise<boolean> | boolean
  onSave?(): Promise<boolean> | boolean
  disableCloseButton?(): boolean
  disableSaveButton?(): boolean
  hideCloseButton?(): boolean
  hideSaveButton?(): boolean
}
