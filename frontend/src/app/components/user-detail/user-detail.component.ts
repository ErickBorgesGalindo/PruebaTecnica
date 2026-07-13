import { Component, EventEmitter, Input, Output, OnChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserService } from '../../services/user.service';

@Component({
  selector: 'app-user-detail',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './user-detail.component.html',
  styleUrl: './user-detail.component.scss'
})
export class UserDetailComponent implements OnChanges {

  @Input() user: any = null;
  @Output() close = new EventEmitter<void>();

  profiles: any[] = [];
  loading = false;

  constructor(private userService: UserService) {}

  ngOnChanges(): void {
    if (this.user) {
      this.loadProfiles();
    }
  }

  loadProfiles(): void {
    this.loading = true;
    this.userService.getUserProfiles(this.user.id).subscribe({
      next: (data) => {
        this.profiles = data;
        this.loading = false;
      },
      error: () => {
        this.loading = false;
      }
    });
  }

  onClose(): void {
    this.close.emit();
  }
}