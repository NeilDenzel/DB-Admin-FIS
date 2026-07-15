<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Rezago Académico</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; font-size: 10px; color: #1e293b; }
        h1 { font-size: 16px; text-align: center; margin-bottom: 4px; color: #1e3a5f; }
        h2 { font-size: 11px; text-align: center; margin-top: 0; font-weight: normal; color: #64748b; }
        .header { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #1e3a5f; color: white; padding: 6px 8px; text-align: left; font-size: 9px; }
        td { padding: 5px 8px; border-bottom: 1px solid #e2e8f0; }
        .student-row { background: #f8fafc; }
        .student-row td { font-weight: bold; }
        .curso-row td { padding-left: 24px; }
        .badge { display: inline-block; padding: 1px 6px; border-radius: 3px; font-size: 8px; }
        .bg-red { background: #fecaca; color: #991b1b; }
        .bg-yellow { background: #fef08a; color: #854d0e; }
        .bg-orange { background: #fed7aa; color: #9a3412; }
        .bg-slate { background: #e2e8f0; color: #475569; }
        .footer { margin-top: 20px; font-size: 8px; color: #94a3b8; text-align: center; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Rezago Académico</h1>
        <h2>Estudiantes con cursos en estado distinto de "Aprobado"</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Código</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Cursos en Riesgo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rezago as $i => $r)
            <tr class="student-row">
                <td>{{ $i + 1 }}</td>
                <td>{{ $r['cod_estudiante'] }}</td>
                <td>{{ $r['apellidos'] }}</td>
                <td>{{ $r['nombres'] }}</td>
                <td>{{ count($r['cursos']) }}</td>
            </tr>
                @foreach($r['cursos'] as $c)
                <tr class="curso-row">
                    <td></td>
                    <td colspan="2">{{ $c['cod_curso'] }} - {{ $c['curso'] }}</td>
                    <td colspan="2">
                        @php
                            $css = match($c['estado']) {
                                'Desaprobado' => 'bg-red',
                                'En Peligro'  => 'bg-yellow',
                                'Pendiente'   => 'bg-orange',
                                default       => 'bg-slate',
                            };
                        @endphp
                        <span class="badge {{ $css }}">{{ $c['estado'] }}</span>
                    </td>
                </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} — Sistema de Seguimiento Académico FIS-UNCP
    </div>
</body>
</html>
