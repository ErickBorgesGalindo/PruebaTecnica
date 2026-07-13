import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class ProfileService {

  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getProfiles(): Observable<any[]> {
    return this.http.get<any[]>(`${this.apiUrl}/profiles`);
  }

  createProfile(profile: any): Observable<any> {
    return this.http.post(`${this.apiUrl}/profiles`, profile);
  }

  updateProfile(id: any, profile: any): Observable<any> {
    return this.http.put(`${this.apiUrl}/profiles/${id}`, profile);
  }

  deleteProfile(id: any): Observable<any> {
    return this.http.delete(`${this.apiUrl}/profiles/${id}`);
  }
}