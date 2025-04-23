import {Directive, Inject, Injector, OnInit} from '@angular/core';
import {
  ControlValueAccessor,
  FormControl,
  FormControlName,
  FormGroupDirective,
  NgControl,
  Validators
} from '@angular/forms';
import {distinctUntilChanged, startWith, Subject, takeUntil} from 'rxjs';
import {tap} from 'rxjs/operators';

@Directive({
  selector: '[appControlValueAccessor]',
  standalone: false
})
export class ControlValueAccessorDirective<T> implements ControlValueAccessor, OnInit {
  private onTouched!: () => T
  control: FormControl;
  private _destroy$ = new Subject<void>();
  private isRequired: boolean | undefined;
  private _isDisabled: boolean;

  constructor(@Inject(Injector) private injector: Injector) {}

  ngOnInit() {

    try {
      const formControl = this.injector.get(NgControl)

      switch (formControl.constructor) {
        case FormControlName:
          this.control = this.injector.get(FormGroupDirective).getControl(formControl as FormControlName)

          console.log('control', this.control)

          break;
      }
      this.isRequired = this.control?.hasValidator(Validators.required)
    } catch (error) {
      this.control = new FormControl()
    }
  }

  registerOnChange(fn: (val: T | null) => T): void {
    this.control.valueChanges.pipe(takeUntil(this._destroy$),
      startWith(this.control.value),
      distinctUntilChanged(),
      tap(val => fn(val))
    ).subscribe(() => this.control?.markAsUntouched())
  }

  registerOnTouched(fn: any): void {
    this.onTouched = fn;
  }

  setDisabledState(isDisabled: boolean): void {
    this._isDisabled = isDisabled
  }

  writeValue(value: T): void {
    this.control
      ? this.control.setValue(value)
      : (this.control = new FormControl(value))
  }
}
