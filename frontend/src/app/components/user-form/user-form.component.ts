import { Component, EventEmitter, Input, Output, OnChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-user-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './user-form.component.html',
  styleUrl: './user-form.component.scss'
})
export class UserFormComponent implements OnChanges {

  @Input() userToEdit: any = null;
  @Output() userCreated = new EventEmitter<void>();

  name = '';
  email = '';
  phone = '';
  photo_url = '';
  errorMessage = '';
  isEditing = false;
  editId = '';

  constructor(private userService: UserService) {}

  ngOnChanges(): void {
    if (this.userToEdit) {
      this.isEditing = true;
      this.editId = this.userToEdit.id;
      this.name = this.userToEdit.name;
      this.email = this.userToEdit.email;
      this.phone = this.userToEdit.phone || '';
      this.photo_url = this.userToEdit.photo_url || '';
    } else {
      this.resetForm();
    }
  }

  onSubmit(): void {
    this.errorMessage = '';

    if (!this.name || !this.email || !this.photo_url) {
      this.errorMessage = 'Nombre, Email y Foto son obligatorios';
      return;
    }

    const data = {
      name: this.name,
      email: this.email,
      phone: this.phone,
      photo_url: this.photo_url
    };

    if (this.isEditing) {
      this.userService.updateUser(this.editId, data).subscribe({
        next: () => {
          this.resetForm();
          this.userCreated.emit();
        },
        error: () => {
          this.errorMessage = 'Error al actualizar el usuario';
        }
      });
    } else {
      this.userService.createUser(data).subscribe({
        next: () => {
          this.resetForm();
          this.userCreated.emit();
        },
        error: (err) => {
          this.errorMessage = err.error?.message || 'Error al crear el usuario';
        }
      });
    }
  }

  resetForm(): void {
    this.isEditing = false;
    this.editId = '';
    this.name = '';
    this.email = '';
    this.phone = '';
    this.photo_url = '';
    this.errorMessage = '';
  }
}