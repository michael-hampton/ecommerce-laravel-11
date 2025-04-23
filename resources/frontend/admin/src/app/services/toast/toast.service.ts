import {Observable, of, Subscription, throwError, timer} from 'rxjs';
import {EnumTimeout, IToast} from './toast.model';
import {keys} from '../../core/locale/resources';
import {Res} from '../../core/res';
import {StateService} from '../state.abstract';
import {IUiError} from '../../core/error.model';

export class Toast extends StateService<IToast> {
  // keep track of timeout
  private isCanceled: Subscription;

  // public dismiss button
  dismissButton = {
    css: 'btn btn-secondary btn-sm',
    text: keys.DISMISS,
    click: (event: MouseEvent) => {
      this.Hide();
    },
  };

  private defaultOptions: IToast = {
    css: 'toast',
    extracss: '',
    text: '',
    // add dismiss by default
    buttons: [this.dismissButton],
    timeout: EnumTimeout.Short,
    visible: false,
  };

  constructor() {
    super();
    // set intial state
    this.SetState(this.defaultOptions);
  }

  Show(code: string, options?: IToast, message: string = '') {
    // first hide and kill the timer
    this.Hide();

    // extend default options
    const _options: IToast = {...this.defaultOptions, ...options};

    if (message === '') {
      message = Res.Get(code, options?.text || keys.Unknown);
    }

    // timeout a bit to allow for animation effect
    timer(100).subscribe(() => {
      this.SetState({..._options, text: message, visible: true});
    });

    // timeout and hide
    if (_options.timeout > EnumTimeout.Never) {
      this.isCanceled = timer(_options.timeout).subscribe(() => {
        this.Hide();
      });
    }
  }

  // short cuts for specific styles
  ShowError(code: string, options?: IToast, message: string = '') {
    this.Show(code, {extracss: 'bg-danger', ...options}, message);
  }

  ShowSuccess(code: string, options?: IToast, message: string = '') {
    this.Show(code, {extracss: 'bg-success', ...options}, message);
  }

  ShowWarning(code: string, options?: IToast, message: string = '') {
    this.Show(code, {extracss: 'bg-warning', ...options}, message);
  }

  Hide() {
    // find subscroption and unsubscribe
    if (this.isCanceled) {
      this.isCanceled.unsubscribe();
    }
    // reset to visible
    this.UpdateState({visible: false});
  }

  // show code then return null
  HandleUiError(error: IUiError, options?: IToast): Observable<any> {
    // if error.code exists it is our error

    if (error.code) {
      // do a switch case for specific errors
      switch (error.status) {
        case 500:
          // terrible error, code always unknown
          this.ShowError('Unknown', options);
          break;
        case 400:
          // server error
          this.ShowError(error.code, options);
          break;
        case 401:
        case 403:
          // auth error, just show a unified message, need to add options for button
          this.Show('UNAUTHORIZED', options);
          break;
        case 404:
          // thing does not exist, better let each component decide
          this.ShowWarning(error.code, options);
          break;
        default:
          // other errors
          this.ShowError(error.code, options);
      }
      return of(null);
    } else {
      // else, throw it back to Angular Error Service, this is a JS error
      return throwError(() => error);
    }
  }
}
