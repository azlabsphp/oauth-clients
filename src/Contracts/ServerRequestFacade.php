<?php

namespace Drewlabs\Oauth\Clients\Contracts;

interface ServerRequestFacade
{
    /**
     * Gets cookie value from the user provided name.
     *
     * @param mixed $request Framework dependant request instance
     * @param string $name
     *
     * @return string|null
     */
    public function getRequestCookie($request, string $name = null);

    /**
     * Get the request client IP address.
     * 
     * @param mixed $request Framework dependant request instance
     * @return mixed 
     */
    public function getRequestIp($request);


    /**
     * Get header value for request header name. 
     * Case the header is returns an array, the implementation should
     * return a string with array values joined using `,` character like
     * a request header line.
     * 
     * @param mixed $request Framework dependant request instance
     * @param string $name 
     * @param mixed $default
     * 
     * @return string|null
     */
    public function getRequestHeader($request, string $name, $default = null);

    /**
     * Get the value from the request attributes. Implementation can provides
     * a search in request query and/or request parsed body for value matching the
     * provided name.
     * 
     * @param mixed $request
     * @param string $name
     *  
     * @return mixed|null 
     */
    public function getRequestAttribute($request, string $name);

    /**
     * Query request authorization header from the list of request headers
     *
     * @param mixed                  $request Framework dependant request instance
     * @param string                 $header
     * @param string                 $method Authorization method to be used (ex: bearer, basic, jwt, etc...)
     *
     * @return string|null
     */
    public function getAuthorizationHeader($request, string $method = null);
}
