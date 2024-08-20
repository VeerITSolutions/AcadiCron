<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class StudentListController extends Controller
{
    public function searchdtByClassSection($class_id = 2, $section_id = 1)
{

    $i = 1;
    $custom_fields = DB::table('custom_fields')->where('belong_to', 'students')->where('is_active', 1)->get();
    $field_var_array = [];
    $field_var_array_name = [];

    if (!empty($custom_fields)) {
        foreach ($custom_fields as $custom_field) {
            $tb_counter = "table_custom_" . $i;
            $field_var_array[] = DB::raw($tb_counter . '.field_value as ' . $custom_field->name);
            $field_var_array_name[] = $tb_counter . '.field_value';

            DB::table('custom_field_values as ' . $tb_counter)
                ->leftJoin('students', 'students.id', '=', $tb_counter . '.belong_table_id')
                ->where($tb_counter . '.custom_field_id', '=', $custom_field->id);

            $i++;
        }
    }

    $field_variable = !empty($field_var_array) ? ',' . implode(',', $field_var_array) : '';
    $field_name = !empty($field_var_array_name) ? ',' . implode(',', $field_var_array_name) : '';

    $data = Students::select('*')->limit(10)->get();
        $message = '';


return Response::json([
    'success' => true,
    'data' => $data,
    'message' => $message,
], 200);



}

}
