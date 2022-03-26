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

trait ApiResponser
{
	/**
     * Return a success JSON response.
     *
     * @param  array|string  $data
     * @param  string  $message
     * @param  int|null  $code
     * @return \Illuminate\Http\JsonResponse
     */
	protected function success($data, string $message = null, int $code = 200)
	{
		return response()->json([
			'status' => 'Success',
			'message' => $message,
			'data' => $data
		], $code);
	}

	/**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  int  $code
     * @param  array|string|null  $data
     * @return \Illuminate\Http\JsonResponse
     */
	protected function error(string $message = null, int $code, $data = null)
	{
		return response()->json([
			'status' => 'Error',
			'message' => $message,
			'data' => $data
		], $code);
	}

    /**
     * Retornar status de informação
     *
     * @param string|null $message
     * @param string $troute
     * @param integer $code
     * @param [type] $data
     * @return void
     */
    protected function info(string $message = null, string $troute, int $code, $data = null)
	{
        return redirect()->route($troute)->with([
            'status' => 'Info',
			'message' => $message,
        ], $code)->withInput();
	}

    /**
     * Retorna mensagem de aviso.
     *
     * @param string|null $message
     * @param string $troute
     * @param integer $code
     * @param [type] $data
     * @return void
     */
    protected function warning(string $message = null, string $troute, int $code, $data = null)
	{
        return redirect()->route($troute)->with([
            'status' => 'Warning',
			'message' => $message,
        ], $code)->withInput();
	}

}
