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
     * @param [type] $data
     * @param string|null $message
     * @param string|null $troute
     * @param integer $code
     * @return void
     */
	protected function success(string $message = null, int $code = 200, $data = "")
	{
        return redirect()->back()->with([
            'status' => 'Success',
			'message' => $message,
            'data' => $data,
        ], $code);
	}

	/**
      * Return an error DATA response.
      *
      * @param string|null $message
      * @param string $troute
      * @param integer $code
      * @param [type] $data
      * @return void
      */
	protected function error(string $message = null, int $code, $data = null)
	{
        ///
        return redirect()->back()->with([
            'status' => 'Error',
			'message' => $message,
        ], $code)->withInput();
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
    protected function info(string $message = null, int $code, $data = null)
	{
        return redirect()->back()->with([
            'status' => 'Info',
			'message' => $message,
        ], $code)->withInput();
	}

    /**
     * Retiorna mensagem de aviso
     *
     * @param string|null $message
     * @param string $troute
     * @param integer $code
     * @param [type] $data
     * @return void
     */
    protected function warning(string $message = null, string $troute, int $code, $data = null)
	{
        return redirect()->back()->with([
            'status' => 'Warning',
			'message' => $message,
        ], $code)->withInput();
	}

}
