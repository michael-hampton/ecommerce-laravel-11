import { Directive, ElementRef, inject, Input } from '@angular/core';

@Directive({
  selector: '[appDatePassed]',
  standalone: false
})
export class DatePassedDirective {
  private el = inject(ElementRef);
  @Input() date

  constructor() {

  }

  ngOnInit() {
    const dateInPast = (firstDate, secondDate) =>
      firstDate.setHours(0, 0, 0, 0) <= secondDate.setHours(0, 0, 0, 0);

    if (!dateInPast(new Date(this.date), new Date())) {
      this.el.nativeElement.innerHTML = `<div class="text-body fs-xs">Expiration ${this.date}</div>`
    } else {
       this.el.nativeElement.innerHTML = `<div class="text-danger fs-xs">Expired ${this.date}</div>`
    }
  }

}
