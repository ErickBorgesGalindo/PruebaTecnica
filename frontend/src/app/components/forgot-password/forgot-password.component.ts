import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { RouterLink } from '@angular/router';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-forgot-password',
  standalone: true,
  imports: [CommonModule, FormsModule, RouterLink],
  templateUrl: './forgot-password.component.html',
  styleUrl: './forgot-password.component.scss'
})
export class ForgotPasswordComponent {
  email = '';
  tempPassword = '';
  errorMessage = '';
  successMessage = '';
  loading = false;

  constructor(private authService: AuthService) {}

  onSubmit(): void {
    this.errorMessage = '';
    this.successMessage = '';
    this.loading = true;

    this.authService.forgotPassword(this.email).subscribe({
      next: (res: any) => {
        this.tempPassword = res.temp_password;
        this.successMessage = res.message;
        this.loading = false;
      },
      error: (err) => {
        this.errorMessage = err.error?.message || 'Error al recuperar contraseña';
        this.loading = false;
      }
    });
  }
}