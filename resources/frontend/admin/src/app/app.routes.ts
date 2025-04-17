import { Routes } from '@angular/router';
import {DashboardComponent} from './components/dashboard/dashboard.component';
import {AttributeValuesComponent} from './components/attribute-values/attribute-values.component';
import {AttributesComponent} from './components/attributes/attributes.component';
import {BrandsComponent} from './components/brands/brands.component';
import {CategoriesComponent} from './components/categories/categories.component';
import {CouponsComponent} from './components/coupons/coupons.component';
import {OrdersComponent} from './components/orders/orders.component';
import {ProductsComponent} from './components/products/products.component';
import {SlidesComponent} from './components/slides/slides.component';
import {UsersComponent} from './components/users/users.component';
import {SettingsComponent} from './components/settings/settings.component';

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
