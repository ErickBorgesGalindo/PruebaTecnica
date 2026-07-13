import { Component, EventEmitter, Input, Output, OnChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { ProfileService } from '../../services/profile.service';

@Component({
  selector: 'app-profile-form',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './profile-form.component.html',
  styleUrl: './profile-form.component.scss'
})
export class ProfileFormComponent implements OnChanges {

  @Input() profileToEdit: any = null;
  @Output() profileCreated = new EventEmitter<void>();

  name = '';
  sections: string[] = [];
  availableSections = ['products', 'users', 'profiles'];
  errorMessage = '';
  isEditing = false;
  editId = '';

  constructor(private profileService: ProfileService) {}

  ngOnChanges(): void {
    if (this.profileToEdit) {
      this.isEditing = true;
      this.editId = this.profileToEdit.id;
      this.name = this.profileToEdit.name;
      this.sections = [...this.profileToEdit.sections];
    } else {
      this.resetForm();
    }
  }

  toggleSection(section: string): void {
    if (this.sections.includes(section)) {
      this.sections = this.sections.filter(s => s !== section);
    } else {
      this.sections.push(section);
    }
  }

  onSubmit(): void {
    this.errorMessage = '';

    if (!this.name || this.sections.length === 0) {
      this.errorMessage = 'Nombre y al menos una sección son obligatorios';
      return;
    }

    const data = { name: this.name, sections: this.sections };

    if (this.isEditing) {
      this.profileService.updateProfile(this.editId, data).subscribe({
        next: () => { this.resetForm(); this.profileCreated.emit(); },
        error: () => { this.errorMessage = 'Error al actualizar el perfil'; }
      });
    } else {
      this.profileService.createProfile(data).subscribe({
        next: () => { this.resetForm(); this.profileCreated.emit(); },
        error: () => { this.errorMessage = 'Error al crear el perfil'; }
      });
    }
  }

  resetForm(): void {
    this.isEditing = false;
    this.editId = '';
    this.name = '';
    this.sections = [];
    this.errorMessage = '';
  }
}