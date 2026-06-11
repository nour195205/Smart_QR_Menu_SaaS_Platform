// ─── Data source ─────────────────────────────────────────────────────────────
// Dev:  Vite proxies /data/* → Laravel local storage (vite.config.js)
// Prod: Read directly from GitHub Raw CDN — no Netlify rebuild needed,
//       menu updates go live within seconds of a Publish.

const GITHUB_RAW_BASE = `https://raw.githubusercontent.com/${import.meta.env.VITE_GITHUB_OWNER}/${import.meta.env.VITE_GITHUB_REPO}/${import.meta.env.VITE_GITHUB_BRANCH}/frontend/public/data`;

const getMenuUrl = (slug) =>
  import.meta.env.DEV
    ? `/data/${slug}.json`
    : `${GITHUB_RAW_BASE}/${slug}.json`;

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
