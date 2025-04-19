import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';

const routes: Routes = [
  {
    path: 'products',
    loadChildren: () => import('./features/products/products.module').then(m => m.ProductsModule)
  },
  {
    path: 'attribute-values',
    loadChildren: () => import('./features/attribute-values/attribute-values.module').then(m => m.AttributeValuesModule)
  },
  {
    path: 'attributes',
    loadChildren: () => import('./features/attributes/attributes.module').then(m => m.AttributesModule)
  },
  {
    path: 'brands',
    loadChildren: () => import('./features/brands/brands.module').then(m => m.BrandsModule)
  },
  {
    path: 'categories',
    loadChildren: () => import('./features/categories/categories.module').then(m => m.CategoriesModule)
  },
  {
    path: 'coupons',
    loadChildren: () => import('./features/coupons/coupons.module').then(m => m.CouponsModule)
  },
  {
    path: '',
    loadChildren: () => import('./features/dashboard/dashboard.module').then(m => m.DashboardModule)
  },
  {
    path: 'orders',
    loadChildren: () => import('./features/orders/orders.module').then(m => m.OrdersModule)
  },
  {
    path: 'settings',
    loadChildren: () => import('./features/settings/settings.module').then(m => m.SettingsModule)
  },
  {
    path: 'slides',
    loadChildren: () => import('./features/slides/slides.module').then(m => m.SlidesModule)
  },
  {
    path: 'users',
    loadChildren: () => import('./features/users/users.module').then(m => m.UsersModule)
  },

];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
