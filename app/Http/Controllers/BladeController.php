<?php
/**
 * Date: 16/5/12
 * Time: 下午5:20
 */

namespace App\Http\Controllers;


class BladeController extends Controller
{
    public function index($sec1 = null, $sec2 = null, $sec3 = null, $sec4 = null)
    {
        //构建view 的path
        $path = '';
        for ($i = 1; $i < 5; $i++) {
            $var = 'sec' . $i;
            $sec = ${$var};
            if (!is_string($sec)) {
                break;
            }
            $path .= '.' . $sec;
        }
        $path = trim($path, '.');

        //构建view 的data
        $data = [];
        $jsonFile = resource_path('json/blade/') . str_replace('.', '/', $path) . '.json';
        if (file_exists($jsonFile)) {
            $data = json_decode(file_get_contents($jsonFile));
        }

        return response()->view($path, (array)$data);
    }

}