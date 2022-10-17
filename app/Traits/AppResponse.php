<?php


namespace App\Traits;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait AppResponse
{

    /**
     * Return a success DATA response.
     *
     * @param int $type
     * @param [type] $data
     * @param string|null $message
     * @param string|null $troute
     * @param integer $code
     * @return void
     */
	protected function success(int $type, string $message = null, int $code = 200, $data = "")
	{
        if ($type == 0) {
            return redirect()->back()->with([
                'status' => 'Success',
                'message' => $message,
                'data' => $data,
            ], $code);

        } elseif ($type == 1) {
            return response()->json([
                'status' => 'Success',
                'message' => $message,
                'data' => $data
            ], $code);
        }
	}

	/**
      * Return an error DATA response.
      *
      * @param int $type
      * @param string|null $message
      * @param string $troute
      * @param integer $code
      * @param [type] $data
      * @return void
      */
	protected function error(int $type, string $message = null, int $code, $data = null)
	{
        if ($type == 0) {
            return redirect()->back()->with([
                'status' => 'Error',
                'message' => $message,
            ], $code)->withInput();

        } elseif ($type == 1) {
            return response()->json([
                'status' => 'Error',
                'message' => $message,
                'data' => $data
            ], $code);
        }
	}

    /**
     * Retornar status de informação
     *
     * @param int $type
     * @param string|null $message
     * @param string $troute
     * @param integer $code
     * @param [type] $data
     * @return void
     */
    protected function info(int $type, string $message = null, int $code, $data = null)
	{
        if ($type == 0) {
            return redirect()->back()->with([
                'status' => 'Info',
                'message' => $message,
            ], $code)->withInput();

        } elseif ($type == 1) {
            return response()->json([
                'status' => 'Info',
                'message' => $message,
                'data' => $data
            ], $code);
        }
        
	}

    /**
     * Retiorna mensagem de aviso
     * 
     * @param int $type
     * @param string|null $message
     * @param string $troute
     * @param integer $code
     * @param [type] $data
     * @return void
     */
    protected function warning(int $type, string $message = null, string $troute, int $code, $data = null)
	{
        if ($type == 0) {
            return redirect()->back()->with([
                'status' => 'Warning',
                'message' => $message,
            ], $code)->withInput();

        } elseif ($type == 1) {
            return response()->json([
                'status' => 'Warning',
                'message' => $message,
                'data' => $data
            ], $code);
        }

        
	}

}
