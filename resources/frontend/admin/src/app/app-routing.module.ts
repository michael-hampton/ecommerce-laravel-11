import {NgModule} from '@angular/core';
import {RouterModule, Routes} from '@angular/router';
import {LoginResolve} from './core/auth/login.resolve';
import {AuthGuard} from './core/auth/auth.guard';

const routes: Routes = [
  {
    path: 'products',
    loadChildren: () => import('./features/products/products.module').then(m => m.ProductsModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'messages',
    loadChildren: () => import('./features/messages/messages.module').then(m => m.MessagesModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'support',
    loadChildren: () => import('./features/support/support.module').then(m => m.SupportModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'shipping',
    loadChildren: () => import('./features/shipping/shipping.module').then(m => m.ShippingModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'sellers',
    loadChildren: () => import('./features/sellers/sellers.module').then(m => m.SellersModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'attribute-values',
    loadChildren: () => import('./features/attribute-values/attribute-values.module').then(m => m.AttributeValuesModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'attributes',
    loadChildren: () => import('./features/attributes/attributes.module').then(m => m.AttributesModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'brands',
    loadChildren: () => import('./features/brands/brands.module').then(m => m.BrandsModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'categories',
    loadChildren: () => import('./features/categories/categories.module').then(m => m.CategoriesModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'coupons',
    loadChildren: () => import('./features/coupons/coupons.module').then(m => m.CouponsModule),
    canActivate: [AuthGuard],
  },
  {
    path: '',
    loadChildren: () => import('./features/dashboard/dashboard.module').then(m => m.DashboardModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'orders',
    loadChildren: () => import('./features/orders/orders.module').then(m => m.OrdersModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'settings',
    loadChildren: () => import('./features/settings/settings.module').then(m => m.SettingsModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'slides',
    loadChildren: () => import('./features/slides/slides.module').then(m => m.SlidesModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'users',
    loadChildren: () => import('./features/users/users.module').then(m => m.UsersModule),
    canActivate: [AuthGuard],
  },
  {
    path: 'login',
    loadChildren: () => import('./public/login/login.module').then(m => m.LoginModule),
    resolve: {
      ready: LoginResolve,
    },
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule {
}
