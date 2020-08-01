<?php

namespace GetCandy\Hub\Http\Controllers\OrderProcessing;

use GetCandy\Hub\Http\Controllers\Controller;

class SettingController extends Controller
{

    public function getSettings()
    {
        return view('hub::order-processing.settings.index');
    }

    public function getSetting($id)
    {
        return view('hub::order-processing.settings.edit', [
            'id' => $id,
        ]);
    }


}
