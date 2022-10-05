<?php

use App\Models\Branch;
use App\Models\Order;

if (!function_exists('vue_form'))
{
    function vue_form($data, $options = [], $additional = [])
    {
        return response()->json([
            'submitting' => false,
            'data' => $data,
            'options' => $options,
            'additional' => $additional,
        ]);
    }
}

if (!function_exists('server_error'))
{
    function server_error($msg = null)
    {
        return response()->json([
            'message' => $msg ?? 'server.error',
        ], 500);
    }
}

if (!function_exists('success'))
{
    function success($msg = null, $data = null)
    {
        return response()->json([
            'message' => $msg ?? 'success',
            'data' => $data
        ]);
    }
}

if (!function_exists('json_data'))
{
    function json_data($data)
    {
        return response()->json($data);
    }
}

if (!function_exists('generate_branch'))
{
    function generate_branch()
    {
        $last_branch = Branch::where('branch_code', '!=', config('app.default_branch'))->select('branch_code')->orderBy('branch_code', 'desc')->first();
        if (!$last_branch) return '100000';

        $branch_code = intval($last_branch->branch_code);

        return str_pad(($branch_code + 1), 6, '0', STR_PAD_LEFT);
    }
}