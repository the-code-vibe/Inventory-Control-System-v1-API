window.onload = function() {
  window.ui = SwaggerUIBundle({
    url: "https://collaborative.vitorgabrieldev.io/gerenciador-estoque/api/public/docs/api-docs.json",
    dom_id: '#swagger-ui',
    deepLinking: true,
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    plugins: [
      SwaggerUIBundle.plugins.DownloadUrl
    ],
    layout: "StandaloneLayout"
  });
};
