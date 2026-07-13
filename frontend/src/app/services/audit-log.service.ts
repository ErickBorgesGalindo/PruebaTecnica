import { Injectable } from '@angular/core';
import { HttpClient, HttpParams } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';

@Injectable({
  providedIn: 'root'
})
export class AuditLogService {

  private apiUrl = environment.apiUrl;

  constructor(private http: HttpClient) {}

  getLogs(entityType: string = '', action: string = ''): Observable<any> {
    let params = new HttpParams();
    if (entityType) params = params.set('entity_type', entityType);
    if (action) params = params.set('action', action);
    return this.http.get<any>(`${this.apiUrl}/audit-logs`, { params });
  }
}