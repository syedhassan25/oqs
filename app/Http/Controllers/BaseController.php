<?php

namespace App\Http\Controllers;

use App\Traits\FlashMessages;

class BaseController extends Controller
{
    use FlashMessages;

    protected function setPageTitle($title, $subTitle)
    {
        view()->share(['pageTitle' => $title, 'subTitle' => $subTitle]);
    }

    protected function showErrorPage($errorCode = 404, $message = null)
    {
        $data['message'] = $message;
        return response()->view('errors.' . $errorCode, $data, $errorCode);
    }

    protected function responseJson($error = true, $responseCode = 200, $message = [], $data = null)
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function responseRedirect($route, $message, $type = 'info', $error = false, $withOldInputWhenError = false,$id = false)
    {
        $this->setFlashMessage($message, $type);
        $this->showFlashMessages();

        if ($error && $withOldInputWhenError) {
            return redirect()->back()->withInput();
        }

        
        if($id){
            return redirect()->route($route,$id);
        }

        return redirect()->route($route);
    }


    protected function responseRedirectBack($message, $type = 'info', $error = false, $withOldInputWhenError = false)
{
    $this->setFlashMessage($message, $type);
    $this->showFlashMessages();

    return redirect()->back();
}
}
