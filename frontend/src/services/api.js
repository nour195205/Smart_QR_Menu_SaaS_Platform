// ─── Data source ─────────────────────────────────────────────────────────────
// Dev:  Vite proxies /data/* → Laravel local storage (vite.config.js)
// Prod: Read directly from GitHub Raw CDN — no Netlify rebuild needed,
//       menu updates go live within seconds of a Publish.

const GITHUB_RAW_BASE = 'https://raw.githubusercontent.com/nour195205/Smart_QR_Menu_SaaS_Platform/main/frontend/public/data';

const getMenuUrl = (slug) =>
  import.meta.env.DEV
    ? `/data/${slug}.json`
    // ?t= busts GitHub's CDN cache (300s TTL) so every visit gets truly fresh data
    : `${GITHUB_RAW_BASE}/${slug}.json?t=${Date.now()}`;

/**
 * Fetch the full menu JSON for a given slug.
 * @param {string} slug
 * @returns {Promise<object>}
 */
export const fetchMenuData = async (slug) => {
  const response = await fetch(getMenuUrl(slug), {
    cache: 'no-store',
    headers: { Accept: 'application/json' },
  });

  if (!response.ok) {
    throw new Error(response.status === 404 ? 'Menu not found' : 'Failed to load menu');
  }

  return response.json();
};
