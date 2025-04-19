import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {FieldValidationFlagDirective} from './directives/field-validation-flag.directive';
import {FormSubmitDirective} from "./directives/form-submit.directive";
import {ControlErrorComponent} from './components/control-error/control-error.component';

@NgModule({
  declarations: [FieldValidationFlagDirective, FormSubmitDirective],
  imports: [
    CommonModule,
    ControlErrorComponent
  ],
  exports: [
    FormSubmitDirective,
    FieldValidationFlagDirective
  ]
})
export class SharedModule { }
