<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listado de Usuarios</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Helvetica, Arial, sans-serif; font-size: 11px; color: #333; }
        .header { background-color: #1a1a2e; color: #fff; padding: 20px 30px; margin-bottom: 5px; }
        .header h1 { font-size: 20px; font-weight: 700; margin-bottom: 2px; }
        .header p { font-size: 11px; color: #aab; }
        .header .date { font-size: 10px; color: #ccd; margin-top: 6px; }
        .content { padding: 20px 30px; }
        .content h2 { font-size: 16px; color: #1a1a2e; margin-bottom: 14px; border-bottom: 2px solid #0f3460; padding-bottom: 6px; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        thead tr { background-color: #1a1a2e; color: #fff; }
        th { padding: 8px 10px; text-align: left; font-weight: 600; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e0e0e0; }
        tbody tr:nth-child(even) { background-color: #f5f7fa; }
        .summary { margin-top: 14px; font-size: 10px; color: #555; font-weight: 600; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; background-color: #f5f7fa; border-top: 1px solid #ddd; padding: 8px 30px; font-size: 9px; color: #888; }
    </style>
</head>
<body>
    <div class="header">
        <h1>TAP Terminal</h1>
        <p>Sistema de Gestion - Area de Desarrollo</p>
        <div class="date">Fecha de exportacion: {{ now()->format('d/m/Y H:i') }}</div>
    </div>

    <div class="content">
        <h2>Listado de Usuarios</h2>
        <table>
            <thead>
                <tr>
                    <th style="width: 15%;">Codigo</th>
                    <th style="width: 25%;">Nombre</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 15%;">Telefono</th>
                    <th style="width: 15%;">Fecha de Creacion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->code }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="summary">Total: {{ count($users) }} usuarios</div>
    </div>

    <div class="footer">
        <span>TAP Terminal - Documento generado automaticamente</span>
    </div>
</body>
</html>