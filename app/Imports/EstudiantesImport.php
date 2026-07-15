<?php

namespace App\Imports;

use App\Models\Estudiante;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class EstudiantesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    private int $rowCount = 0;
    private array $seenCodigos = [];
    private array $seenDnis = [];

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function model(array $row)
    {
        if (empty($row['cod_estudiante']) && empty($row['dni'])) {
            return null;
        }

        $this->rowCount++;

        return new Estudiante([
            'cod_estudiante' => (string) $row['cod_estudiante'],
            'dni'            => $this->padDni($row['dni'] ?? null),
            'nombres'        => (string) $row['nombres'],
            'apellidos'      => (string) $row['apellidos'],
            'correo'         => isset($row['correo']) ? (string) $row['correo'] : null,
            'telefono'       => isset($row['telefono']) ? (string) $row['telefono'] : null,
            'sexo'           => $row['sexo'] ?? null,
            'ciclo_actual'   => $this->cicloANumero($row['ciclo_actual'] ?? null),
        ]);
    }

    public function rules(): array
    {
        return [
            'cod_estudiante' => 'nullable|unique:estudiante,cod_estudiante',
            'dni'            => 'nullable',
            'nombres'        => 'nullable|max:80',
            'apellidos'      => 'nullable|max:80',
            'correo'         => 'nullable|max:120',
            'telefono'       => 'nullable',
            'sexo'           => 'nullable|in:M,F,O',
            'ciclo_actual'   => 'nullable',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($v) {
            $allData = $v->getData();

            foreach ($allData as $rowIndex => $data) {
                $cod = $data['cod_estudiante'] ?? null;
                $dni = $data['dni'] ?? null;

                if (empty($cod) && empty($dni)) {
                    continue;
                }

                if (!empty($cod)) {
                    if (in_array($cod, $this->seenCodigos, true)) {
                        $v->errors()->add("{$rowIndex}.cod_estudiante", "El código {$cod} está duplicado en el archivo.");
                    } else {
                        $this->seenCodigos[] = $cod;
                    }

                    if (empty($data['nombres'] ?? null)) {
                        $v->errors()->add("{$rowIndex}.nombres", 'El campo nombres es obligatorio.');
                    }
                    if (empty($data['apellidos'] ?? null)) {
                        $v->errors()->add("{$rowIndex}.apellidos", 'El campo apellidos es obligatorio.');
                    }

                    $dniPadded = $this->padDni($dni);
                    if (empty($dni)) {
                        $v->errors()->add("{$rowIndex}.dni", 'El campo dni es obligatorio.');
                    } elseif (!preg_match('/^\d{8}$/', $dniPadded)) {
                        $v->errors()->add("{$rowIndex}.dni", 'El DNI debe tener 8 dígitos numéricos.');
                    } elseif (in_array($dniPadded, $this->seenDnis, true)) {
                        $v->errors()->add("{$rowIndex}.dni", "El DNI {$dniPadded} está duplicado en el archivo.");
                    } else {
                        $this->seenDnis[] = $dniPadded;
                        if (DB::table('estudiante')->where('dni', $dniPadded)->exists()) {
                            $v->errors()->add("{$rowIndex}.dni", 'El DNI ya está registrado.');
                        }
                    }
                }
            }
        });
    }

    private function padDni($valor): ?string
    {
        if ($valor === null || $valor === '') {
            return null;
        }
        return str_pad((string) $valor, 8, '0', STR_PAD_LEFT);
    }

    private function cicloANumero($valor): ?int
    {
        if ($valor === null || $valor === '') {
            return null;
        }

        if (is_numeric($valor)) {
            $num = (int) $valor;
            return ($num >= 1 && $num <= 12) ? $num : null;
        }

        $romanos = [
            'I' => 1, 'II' => 2, 'III' => 3, 'IV' => 4, 'V' => 5,
            'VI' => 6, 'VII' => 7, 'VIII' => 8, 'IX' => 9, 'X' => 10,
            'XI' => 11, 'XII' => 12,
        ];

        return $romanos[strtoupper(trim($valor))] ?? null;
    }
}
