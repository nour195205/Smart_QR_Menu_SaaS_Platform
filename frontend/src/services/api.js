export const fetchMenuData = async (slug) => {
  // Uses Vite proxy in development, and native relative path in production
  const url = `/data/${slug}.json`;

  const response = await fetch(url, {
    headers: {
      'Accept': 'application/json',
    },
    // Prevent browser caching, we handle our own localStorage cache
    cache: 'no-store' 
  });

  if (!response.ok) {
    if (response.status === 404) {
      throw new Error('Menu not found');
    }
    throw new Error('Failed to load menu');
  }

  return response.json();
};
