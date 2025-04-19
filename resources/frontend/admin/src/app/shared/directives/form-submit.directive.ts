import { Directive, ElementRef } from '@angular/core';
import { fromEvent, Observable } from 'rxjs';
import { shareReplay, tap } from 'rxjs/operators';

@Directive({
  selector: 'form[admin-form]',
  standalone: false
})
export class FormSubmitDirective {
  submit$: Observable<Event>;

  constructor(private host: ElementRef<HTMLFormElement>) {
    this.submit$ = fromEvent(this.element, 'submit').pipe(shareReplay(1))
  }

  get element() {
    return this.host.nativeElement;
  }
}
