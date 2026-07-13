import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { UserService } from '../../services/user.service';
import { UserFormComponent } from '../user-form/user-form.component';
import { UserDetailComponent } from '../user-detail/user-detail.component';
import { environment } from '../../../environments/environment';

@Component({
  selector: 'app-user-list',
  standalone: true,
  imports: [CommonModule, UserFormComponent, UserDetailComponent],
  templateUrl: './user-list.component.html',
  styleUrl: './user-list.component.scss'
})
export class UserListComponent implements OnInit {
  apiUrl = environment.apiUrl;
  users: any[] = [];
  userToEdit: any = null;
  userDetail: any = null;
  showDetail = false;

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.loadUsers();
  }

  loadUsers(): void {
    this.userService.getUsers().subscribe(data => {
      this.users = data;
    });
  }

  deleteUser(id: any): void {
    if (confirm('¿Estás seguro de eliminar este usuario?')) {
      this.userService.deleteUser(id).subscribe(() => {
        this.loadUsers();
      });
    }
  }

  editUser(user: any): void {
    this.userToEdit = { ...user };
  }

  viewDetail(user: any): void {
    this.userDetail = user;
    this.showDetail = true;
  }

  closeDetail(): void {
    this.showDetail = false;
    this.userDetail = null;
  }

  onFormClose(): void {
    this.userToEdit = null;
    this.loadUsers();
  }
}