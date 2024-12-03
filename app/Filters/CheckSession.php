<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckSession implements FilterInterface
{
  /**
   * Checks if the user is logged in before allowing the request to proceed
   *
   * @param RequestInterface $request
   * @param mixed $arguments
   *
   * @return mixed
   */
  public function before(RequestInterface $request, $arguments = null)
  {
    if (!session('login_info')) {
      return redirect()->to('/');
    }
  }

  public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
  {
    // Do something here
  }
}
