// ─── Constants ───────────────────────────────────────────────────────────────

/** Full menu JSON expires after 24 hours (safety net if version check fails). */
const MENU_CACHE_EXPIRY_MS  = 1000 * 60 * 60 * 24;

/** Version string (generated_at) — no expiry, it's just a lightweight key. */
const VERSION_KEY_PREFIX = 'menu_version_';
const MENU_KEY_PREFIX    = 'menu_';

// ─── Full menu cache ──────────────────────────────────────────────────────────

/**
 * Returns the cached full menu object, or null if absent / expired.
 * @param {string} slug
 * @returns {object|null}
 */
export const getCachedMenu = (slug) => {
  try {
    const raw = localStorage.getItem(`${MENU_KEY_PREFIX}${slug}`);
    if (!raw) return null;

    const { timestamp, data } = JSON.parse(raw);

    if (Date.now() - timestamp > MENU_CACHE_EXPIRY_MS) {
      localStorage.removeItem(`${MENU_KEY_PREFIX}${slug}`);
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
      `${MENU_KEY_PREFIX}${slug}`,
      JSON.stringify({ timestamp: Date.now(), data }),
    );
  } catch (e) {
    console.warn('Failed to save menu to cache', e);
  }
};

// ─── Version cache (tiny, just the ISO timestamp string) ─────────────────────

/**
 * Returns the cached version string (generated_at) for a slug, or null.
 * @param {string} slug
 * @returns {string|null}
 */
export const getCachedVersion = (slug) => {
  try {
    return localStorage.getItem(`${VERSION_KEY_PREFIX}${slug}`) ?? null;
  } catch {
    return null;
  }
};

/**
 * Persist the version string for a slug.
 * @param {string} slug
 * @param {string} version  — ISO timestamp (generated_at)
 */
export const setCachedVersion = (slug, version) => {
  try {
    localStorage.setItem(`${VERSION_KEY_PREFIX}${slug}`, version);
  } catch (e) {
    console.warn('Failed to save menu version to cache', e);
  }
};
