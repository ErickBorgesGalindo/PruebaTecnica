import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ProfileService } from '../../services/profile.service';
import { ProfileFormComponent } from '../profile-form/profile-form.component';

@Component({
  selector: 'app-profile-list',
  standalone: true,
  imports: [CommonModule, ProfileFormComponent],
  templateUrl: './profile-list.component.html',
  styleUrl: './profile-list.component.scss'
})
export class ProfileListComponent implements OnInit {
  profiles: any[] = [];
  profileToEdit: any = null;
  profileDetail: any = null;
  showModal = false;

  constructor(private profileService: ProfileService) {}

  ngOnInit(): void {
    this.loadProfiles();
  }

  loadProfiles(): void {
    this.profileService.getProfiles().subscribe(data => {
      this.profiles = data;
    });
  }

  deleteProfile(id: any): void {
    if (confirm('¿Estás seguro de eliminar este perfil?')) {
      this.profileService.deleteProfile(id).subscribe(() => {
        this.loadProfiles();
      });
    }
  }

  editProfile(profile: any): void {
    this.profileToEdit = { ...profile };
  }

  viewDetail(profile: any): void {
    this.profileDetail = profile;
    this.showModal = true;
  }

  closeModal(): void {
    this.showModal = false;
    this.profileDetail = null;
  }

  onFormClose(): void {
    this.profileToEdit = null;
    this.loadProfiles();
  }
}