import {Injectable} from '@angular/core';
import {HttpErrorResponse} from '@angular/common/http';

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

    console.log('error', error)

    // accumulate all errors
    const errors = error.error.errors;
    if (Object.keys(errors).length) {
      Object.keys(errors).forEach((key, value) => {
        e.message += ' ' + errors[key].join('. ');
      });

      // code of first error is enough for ui
      //e.code = errors[0].code || 'Unknown';

      alert(e.message)
    }
  }
  return e;
};

export interface IUiError {
  code: string;
  message?: string;
  status?: number;
}
