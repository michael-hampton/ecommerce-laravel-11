import { Routes } from '@angular/router';
import {DashboardComponent} from './features/dashboard/dashboard.component';
import {AttributeValuesComponent} from './features/attribute-values/attribute-values.component';
import {AttributesComponent} from './features/attributes/attributes.component';
import {BrandsComponent} from './features/brands/brands.component';
import {CategoriesComponent} from './features/categories/categories.component';
import {CouponsComponent} from './features/coupons/coupons.component';
import {OrdersComponent} from './features/orders/orders.component';
import {ProductsComponent} from './features/products/products.component';
import {SlidesComponent} from './features/slides/slides.component';
import {UsersComponent} from './features/users/users.component';
import {SettingsComponent} from './features/settings/settings.component';

export const routes: Routes = [
  {path: '', component:DashboardComponent},
  {path: 'attribute-values', component:AttributeValuesComponent},
  {path: 'attributes', component:AttributesComponent},
  {path: 'brands', component:BrandsComponent},
  {path: 'categories', component:CategoriesComponent},
  {path: 'coupons', component:CouponsComponent},
  {path: 'orders', component:OrdersComponent},
  {path: 'products', component:ProductsComponent},
  {path: 'slides', component:SlidesComponent},
  {path: 'users', component:UsersComponent},
  {path: 'settings', component:SettingsComponent},
];
