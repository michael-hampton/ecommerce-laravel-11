import {
  ComponentFactoryResolver,
  ComponentRef,
  Directive,
  Host,
  Inject,
  InjectionToken,
  OnInit,
  Optional,
  ViewContainerRef,
} from '@angular/core';
import {NgControl} from '@angular/forms';
import {EMPTY, merge, Observable} from 'rxjs';
import {FormSubmitDirective} from './form-submit.directive';
import {ControlErrorComponent} from "../components/control-error/control-error.component";

export const defaultErrors = {
  required: (error) => `This field is required`,
  minlength: ({requiredLength, actualLength}) => `Expect ${requiredLength} but got ${actualLength}`,
  future: (error) => 'The date must be in the future',
  matchPassword: (error) => 'Passwords must match',
  email: (error) => 'You must enter a valid email',
}

export const FORM_ERRORS = new InjectionToken('FORM_ERRORS', {
  providedIn: 'root',
  factory: () => defaultErrors
});

@Directive({
  selector: '[formControlName]',
  standalone: false
})
export class FieldValidationFlagDirective implements OnInit {
  submit$: Observable<Event>;
  ref: ComponentRef<ControlErrorComponent>;

  constructor(
    private control: NgControl,
    @Optional() @Host() private form: FormSubmitDirective,
    @Inject(FORM_ERRORS) private errors,
    private vcr: ViewContainerRef,
    private resolver: ComponentFactoryResolver,
  ) {
    this.submit$ = this.form ? this.form.submit$ : EMPTY;
  }

  ngOnInit() {
    merge(
      this.submit$,
      this.control.valueChanges
    ).pipe(
    ).subscribe(() => {
      const controlErrors = this.control.errors;
      if (controlErrors) {
        const firstKey = Object.keys(controlErrors)[0];
        const getError = this.errors[firstKey];
        const text = getError(controlErrors[firstKey]);

        this.setError(text);
      } else if (this.ref) {
        this.setError(null);
      }
    });
  }

  setError(text: string) {
    if (!this.ref) {
      const factory = this.resolver.resolveComponentFactory(ControlErrorComponent);
      this.ref = this.vcr.createComponent(factory);
    }

    this.ref.instance.text = text;
  }
}
