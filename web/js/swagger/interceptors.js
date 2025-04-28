/**
 * Swagger UI interceptors
 * 
 * @package app
 * @author User
 * @copyright Copyright (c) 2025
 */

/**
 * Bearer token request interceptor
 * Ensures Authorization header always includes Bearer prefix
 * 
 * @param {Object} request - The request object
 * @returns {Object} Modified request object
 */
function bearerTokenInterceptor(request) {
    if (request.headers && 
        request.headers.Authorization && 
        !request.headers.Authorization.startsWith('Bearer ')) {
        request.headers.Authorization = 'Bearer ' + request.headers.Authorization;
    }
    return request;
}
