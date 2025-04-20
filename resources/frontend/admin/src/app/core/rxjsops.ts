import { HttpEventType, HttpResponse } from '@angular/common/http';
import {
  catchError,
  MonoTypeOperatorFunction,
  pipe,
  tap,
  throwError,
} from 'rxjs';
import {UiError} from './error.model';

// the debug operator is used in state and in http service
// for stakblitz, declare here
declare const _debug: (o: any, message?: string, type?: string) => void;

export const debug = (
  message: string,
  type?: string
): MonoTypeOperatorFunction<any> => {
  return pipe(
    tap({
      next: (nextValue) => {
        let value = nextValue;

        if (nextValue instanceof HttpResponse) {
          // value is the body
          value = nextValue.body;
        }
        // just filter out the sent event
        if (nextValue && <any>nextValue.type !== HttpEventType.Sent) {
          //_debug(value, message, type);
        }
      },
    })
  );
};

export const catchAppError = (
  message: string
): MonoTypeOperatorFunction<any> => {
  return pipe(
    catchError((error) => {
      // map out to our model
      const e = UiError(error);

      // log
      _debug(e, message, 'e');

      // throw back to allow UI to handle it
      return throwError(() => e);
    })
  );
};
