/** Full menu JSON expires after 24 hours (safety net only — fresh fetch always happens first). */
const CACHE_EXPIRY_MS = 1000 * 60 * 60 * 24;
const KEY_PREFIX      = 'menu_';

/**
 * Returns the cached full menu object, or null if absent / expired.
 * @param {string} slug
 * @returns {object|null}
 */
export const getCachedMenu = (slug) => {
  try {
    const raw = localStorage.getItem(`${KEY_PREFIX}${slug}`);
    if (!raw) return null;

    const { timestamp, data } = JSON.parse(raw);

    if (Date.now() - timestamp > CACHE_EXPIRY_MS) {
      localStorage.removeItem(`${KEY_PREFIX}${slug}`);
      return null;
    }

    return data;
  } catch {
    return null;
  }
};

/**
 * Persist the full menu object in localStorage.
 * @param {string} slug
 * @param {object} data
 */
export const setCachedMenu = (slug, data) => {
  try {
    localStorage.setItem(
      `${KEY_PREFIX}${slug}`,
      JSON.stringify({ timestamp: Date.now(), data }),
    );
  } catch (e) {
    console.warn('Failed to save menu to cache', e);
  }
};
