import { useState, useEffect } from 'react';
import { fetchMenuData, fetchMenuVersion } from '../services/api';
import { getCachedMenu, setCachedMenu, getCachedVersion, setCachedVersion } from '../utils/cache';

/**
 * useMenuData — Smart data fetching with Two-Step Version Check
 *
 * Strategy:
 *  1. Render from localStorage cache instantly (zero loading time for returning visitors).
 *  2. In the background, fetch ONLY the tiny version file (~40 bytes) from GitHub Raw.
 *  3. Compare remote version with the cached version:
 *       • Same  → no extra request, cache is still fresh. ✅
 *       • Diff  → fetch the full JSON, update cache + UI.  🔄
 *  4. On first visit (no cache) → fetch full JSON directly.
 *
 * This means a returning visitor whose menu hasn't changed makes exactly
 * ONE tiny HTTP request (~40 bytes) instead of downloading the full JSON every time.
 */
export const useMenuData = (slug) => {
  const [data, setData]       = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError]     = useState(null);

  useEffect(() => {
    if (!slug) return;

    let isMounted = true;

    const loadData = async () => {
      try {
        // ── Step 1: Show cached data instantly ──────────────────────────────
        const cachedData = getCachedMenu(slug);

        if (cachedData) {
          if (isMounted) {
            setData(cachedData);
            setLoading(false); // Instant render from cache!
          }
        } else {
          if (isMounted) setLoading(true);
        }

        // ── Step 2: Version probe ────────────────────────────────────────────
        // If we have a cache, first fetch only the tiny version file.
        // Only download the full JSON if the version actually changed.
        if (cachedData) {
          const cachedVersion = getCachedVersion(slug);
          const remoteVersion = await fetchMenuVersion(slug);

          // Version file not available (e.g. older backend) → fall through to full fetch
          if (remoteVersion !== null) {
            if (remoteVersion === cachedVersion) {
              // ✅ Same version — cache is still valid, nothing to do.
              return;
            }
            // 🔄 Version changed — store the new version and fetch full JSON below.
            if (isMounted) setCachedVersion(slug, remoteVersion);
          }
        }

        // ── Step 3: Fetch full JSON ──────────────────────────────────────────
        const freshData = await fetchMenuData(slug);

        if (isMounted) {
          // Guard against a race where version check says "same" but full JSON
          // was already fetched (e.g. no version file on first visit).
          const isNewer =
            !cachedData || cachedData.generated_at !== freshData.generated_at;

          if (isNewer) {
            setData(freshData);
            setCachedMenu(slug, freshData);
            // Persist the version from the JSON itself as fallback
            setCachedVersion(slug, freshData.generated_at);
          }

          setLoading(false);
          setError(null);
        }
      } catch (err) {
        if (isMounted) {
          // Only surface the error when there is no cached fallback.
          if (!getCachedMenu(slug)) {
            setError(err.message || 'An error occurred loading the menu.');
            setLoading(false);
          }
          // If cache exists, silently swallow — visitor still sees valid data.
        }
      }
    };

    loadData();

    return () => {
      isMounted = false;
    };
  }, [slug]);

  return { data, loading, error };
};
