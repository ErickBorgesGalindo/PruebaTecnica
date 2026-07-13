import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { AuditLogService } from '../../services/audit-log.service';

@Component({
  selector: 'app-audit-log-list',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './audit-log-list.component.html',
  styleUrl: './audit-log-list.component.scss'
})
export class AuditLogListComponent implements OnInit {
  logs: any[] = [];
  entityType = '';
  action = '';

  private fieldLabels: Record<string, string> = {
    id: 'ID',
    code: 'Código',
    name: 'Nombre',
    email: 'Usuario',
    brand: 'Marca',
    price: 'Precio',
    phone: 'Teléfono',
    photo_url: 'Foto',
    sections: 'Secciones',
    password: 'Contraseña',
    created_at: 'Fecha creación',
    updated_at: 'Fecha actualización',
    user_id: 'ID Usuario',
    user_name: 'Usuario',
    entity_type: 'Tipo entidad',
    entity_id: 'ID Entidad',
    action: 'Acción',
    old_data: 'Datos anteriores',
    new_data: 'Datos nuevos',
  };

  constructor(private auditLogService: AuditLogService) {}

  ngOnInit(): void {
    this.loadLogs();
  }

  loadLogs(): void {
    this.auditLogService.getLogs(this.entityType, this.action).subscribe(res => {
      this.logs = res.data || res;
    });
  }

  formatData(data: any): string {
    if (!data) return '-';
    const excluded = ['_id', 'updated_at'];
    return Object.keys(data)
      .filter(key => !excluded.includes(key) && data[key] !== null)
      .map(key => {
        const label = this.fieldLabels[key] || key;
        const value = Array.isArray(data[key]) ? data[key].join(', ') : data[key];
        return `${label}: ${value}`;
      })
      .join('\n');
  }

  getEntityLabel(type: string): string {
    const labels: Record<string, string> = {
      product: 'Producto',
      user: 'Usuario',
      profile: 'Perfil'
    };
    return labels[type] || type;
  }

  getActionLabel(action: string): string {
    const labels: Record<string, string> = {
      created: 'Creación',
      updated: 'Edición',
      deleted: 'Eliminación'
    };
    return labels[action] || action;
  }
}