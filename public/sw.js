const CACHE_NAME = "pwa-cache-v1";

self.addEventListener('install', (event) => {
    const urlsToCache = [
      '/',
      '/index.html',
      '/style.css',
      '/script.js',
    ];

    event.waitUntil(
      caches.open('meu-cache').then((cache) => {
        return Promise.all(urlsToCache.map(url => {
          return fetch(url)
            .then(response => {
              if (!response.ok) {
                throw new Error(`Falha ao buscar ${url}`);
              }
              return cache.put(url, response);
            })
            .catch(error => {
              console.error(error);
            });
        }));
      })
    );
  });

