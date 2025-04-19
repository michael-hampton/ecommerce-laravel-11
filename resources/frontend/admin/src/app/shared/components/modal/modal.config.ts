export interface ModalConfig {
  modalTitle: string
  modalBody?: string
  saveButtonLabel?: string
  closeButtonLabel?: string
  shouldClose?(): Promise<boolean> | boolean
  shouldSave?(): Promise<boolean> | boolean
  onClose?(): Promise<boolean> | boolean
  onSave?(): Promise<boolean> | boolean
  disableCloseButton?(): boolean
  disableSaveButton?(): boolean
  hideCloseButton?(): boolean
  hideSaveButton?(): boolean
}
