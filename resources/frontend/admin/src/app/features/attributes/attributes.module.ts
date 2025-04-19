import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import {DataTablesModule} from 'angular-datatables';
import { AttributesRoutingModule } from './attributes-routing.module';
import { FormComponent } from './components/form/form.component';
import { AttributeListComponent } from './components/attribute-list/attribute-list.component';
import {SharedModule} from '../../shared/shared.module';
import {ModalComponent} from "../../shared/components/modal/modal.component";
import {ReactiveFormsModule} from "@angular/forms";
import {FieldValidationFlagDirective} from "../../shared/directives/field-validation-flag.directive";
import {FormSubmitDirective} from "../../shared/directives/form-submit.directive";
import {ControlErrorComponent} from '../../shared/components/control-error/control-error.component';


@NgModule({
  declarations: [
    FormComponent,
    AttributeListComponent
  ],
  imports: [
    CommonModule,
    AttributesRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule,
    ControlErrorComponent
  ]
})
export class AttributesModule { }
