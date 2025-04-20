export enum EnumTimeout {
  Short = 4000, // 4 seconds
  Long = 20000, // 20 seconds
  Never = -1, // never timeout
}
export interface IToast {
  text?: string;
  css?: string; // basic css, defaults to toast
  extracss?: string; // extra styling
  buttons?: IToastButton[]; // action buttons
  timeout?: EnumTimeout; // new for timeout to hide
  visible?: boolean; // to add animation
}

export interface IToastButton {
  text: string;
  css?: string;
  click?: (event: MouseEvent) => void;
}
