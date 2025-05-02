import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { ListComponent } from './categories/components/list/list.component';
import { QuestionListComponent } from './questions/components/question-list/question-list.component';
import { ArticleListComponent } from './articles/article-list/article-list.component';

const routes: Routes = [
  {path: 'categories', component: ListComponent},
  {path: 'questions', component: QuestionListComponent},
  {path: 'articles', component: ArticleListComponent}
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class SupportRoutingModule { }
