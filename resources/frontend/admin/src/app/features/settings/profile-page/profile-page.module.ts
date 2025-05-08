import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { ProfilePageRoutingModule } from './profile-page-routing.module';
import { ReviewsComponent } from './components/reviews/reviews.component';
import { ListingsComponent } from './components/listings/listings.component';
import { ProfileComponent } from './profile.component';
import { ReactiveFormsModule } from '@angular/forms';
import { ProductFormComponent } from '../../../shared/components/product-form/product-form.component';
import { SharedModule } from '../../../shared/shared.module';


@NgModule({
  declarations: [ProfileComponent, ReviewsComponent, ListingsComponent],
  imports: [
    CommonModule,
    ProfilePageRoutingModule,
    ReactiveFormsModule,
    SharedModule
  ]
})
export class ProfilePageModule { }
