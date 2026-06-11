// ─── GitHub Raw CDN base URL (Production) ───────────────────────────────────
// In development: Vite proxies /data/* → Laravel local storage
// In production:  We read directly from GitHub Raw CDN, bypassing Netlify entirely.
//                 This means menu updates appear within seconds of a Publish,
//                 without waiting for a Netlify rebuild.

const GITHUB_RAW_BASE = import.meta.env.DEV
  ? null
  : `https://raw.githubusercontent.com/${import.meta.env.VITE_GITHUB_OWNER}/${import.meta.env.VITE_GITHUB_REPO}/${import.meta.env.VITE_GITHUB_BRANCH}/frontend/public/data`;

/**
 * Builds the URL to the full menu JSON for a given slug.
 * Dev  → /data/{slug}.json   (proxied to Laravel local storage by Vite)
 * Prod → GitHub Raw CDN
 */
const getMenuUrl = (slug) =>
  import.meta.env.DEV
    ? `/data/${slug}.json`
    : `${GITHUB_RAW_BASE}/${slug}.json`;

/**
 * Builds the URL to the tiny version file for a given slug.
 * This file contains only { "v": "<generated_at ISO string>" }
 * and is used as a lightweight version probe before fetching the full JSON.
 *
 * Dev  → /data/{slug}-version.json   (proxied to Laravel local storage)
 * Prod → GitHub Raw CDN
 */
const getVersionUrl = (slug) =>
  import.meta.env.DEV
    ? `/data/${slug}-version.json`
    : `${GITHUB_RAW_BASE}/${slug}-version.json`;

// ─── Exported helpers ────────────────────────────────────────────────────────

/**
 * Fetch the latest version string for a menu.
 * Returns the `v` value (ISO timestamp) or null on failure.
 *
 * @param {string} slug
 * @returns {Promise<string|null>}
 */
export const fetchMenuVersion = async (slug) => {
  try {
    const response = await fetch(getVersionUrl(slug), {
      cache: 'no-store',
      headers: { Accept: 'application/json' },
    });

    if (!response.ok) return null;

    const json = await response.json();
    return json.v ?? null;
  } catch {
    return null;
  }
};

/**
 * Fetch the full menu JSON for a given slug.
 * Throws on network errors or non-200 responses.
 *
 * @param {string} slug
 * @returns {Promise<object>}
 */
export const fetchMenuData = async (slug) => {
  const response = await fetch(getMenuUrl(slug), {
    cache: 'no-store',
    headers: { Accept: 'application/json' },
  });

  if (!response.ok) {
    if (response.status === 404) {
      throw new Error('Menu not found');
    }
    throw new Error('Failed to load menu');
  }

  return response.json();
};
