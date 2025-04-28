/**
 * Swagger UI configuration
 * 
 * @package app
 * @author User
 * @copyright Copyright (c) 2025
 */

/**
 * Create Swagger UI configuration object
 * 
 * @param {string} specUrl - URL to the Swagger JSON specification
 * @returns {Object} Swagger UI configuration
 */
function createSwaggerUIConfig(specUrl) {
    return {
        url: specUrl,
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
            SwaggerUIBundle.presets.apis,
            SwaggerUIStandalonePreset
        ],
        plugins: [
            SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout",
        docExpansion: "list",
        filter: true,
        showExtensions: true,
        persistAuthorization: true,
        requestInterceptor: bearerTokenInterceptor
    };
}
