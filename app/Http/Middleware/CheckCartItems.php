<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCartItems
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      
        if(session()->has('cart.items'))
        {   
            if(!empty(session()->get('cart.items')))
            {
                return $next($request);
            }else{
                toastr()->error('Your cart is empty!');
                return redirect()->route('front.index');
            }
           
        }else{
            toastr()->error('Your cart is empty!');
            return redirect()->route('front.index');
        }
        
    }
}
