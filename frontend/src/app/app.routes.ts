import { Routes } from '@angular/router';
import { LoginComponent } from './components/login/login.component';
import { ProductListComponent } from './components/product-list/product-list.component';
import { UserListComponent } from './components/user-list/user-list.component';
import { ProfileListComponent } from './components/profile-list/profile-list.component';
import { AuditLogListComponent } from './components/audit-log-list/audit-log-list.component';
import { UnauthorizedComponent } from './components/unauthorized/unauthorized.component';
import { AuthGuard } from './guards/auth.guard';
import { SectionGuard } from './guards/section.guard';
import { ForgotPasswordComponent } from './components/forgot-password/forgot-password.component';

export const routes: Routes = [
  { path: 'login', component: LoginComponent },
  { path: 'forgot-password', component: ForgotPasswordComponent },
  { path: 'unauthorized', component: UnauthorizedComponent },
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'products', component: ProductListComponent, canActivate: [AuthGuard, SectionGuard], data: { section: 'products' } },
  { path: 'users', component: UserListComponent, canActivate: [AuthGuard, SectionGuard], data: { section: 'users' } },
  { path: 'profiles', component: ProfileListComponent, canActivate: [AuthGuard, SectionGuard], data: { section: 'profiles' } },
  { path: 'audit-logs', component: AuditLogListComponent, canActivate: [AuthGuard, SectionGuard], data: { section: 'audit-logs' } },
];