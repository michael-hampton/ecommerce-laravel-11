import { HttpErrorResponse } from '@angular/common/http';

export interface IUiError {
  code: string;
  message?: string;
  status?: number;
}

export const UiError = (error: any): IUiError => {
  let e: IUiError = {
    code: 'Unknown',
    message: error,
    status: 0,
  };

  if (error instanceof HttpErrorResponse) {
    // map general error
    e.message = error.message || '';
    e.status = error.status || 0;

    // dig out the message if found
    if (error.error?.errors?.length) {
      // accumulate all errors
      const errors = error.error.errors;
      e.message = errors.map((l: any) => l.message).join('. ');
      // code of first error is enough for ui
      e.code = errors[0].code || 'Unknown';
    }
  }
  return e;
};
