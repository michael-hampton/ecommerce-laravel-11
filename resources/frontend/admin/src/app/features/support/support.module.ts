import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { SupportRoutingModule } from './support-routing.module';
import { ListComponent } from './categories/components/list/list.component';
import { FormComponent } from './categories/components/form/form.component';
import { QuestionListComponent } from './questions/components/question-list/question-list.component';
import { SharedModule } from "../../shared/shared.module";
import { ModalComponent } from "../../shared/components/modal/modal.component";
import { ReactiveFormsModule } from '@angular/forms';
import { DataTablesModule } from 'angular-datatables';
import { QuestionFormComponent } from './questions/components/question-form/question-form.component';
import { ArticleListComponent } from './articles/article-list/article-list.component';
import { ArticleFormComponent } from './articles/article-form/article-form.component';



@NgModule({
  declarations: [
    ListComponent,
    FormComponent,
    QuestionListComponent,
    QuestionFormComponent,
    ArticleListComponent,
    ArticleFormComponent
  ],
  imports: [
    CommonModule,
    SupportRoutingModule,
    DataTablesModule,
    SharedModule,
    ModalComponent,
    ReactiveFormsModule
  ]
})
export class SupportModule { }
