import { useState, useEffect } from 'react';
import { fetchMenuData } from '../services/api';
import { getCachedMenu, setCachedMenu } from '../utils/cache';

/**
 * useMenuData — Stale-While-Revalidate
 *
 * Every time the link is opened:
 *  1. Show cached data instantly (zero loading time for returning visitors).
 *  2. Always fetch fresh JSON from GitHub Raw CDN in the background.
 *  3. If generated_at changed → update cache + UI silently.
 *  4. If same → do nothing, visitor already sees correct data.
 */
export const useMenuData = (slug) => {
  const [data, setData]       = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError]     = useState(null);

  useEffect(() => {
    if (!slug) return;

    let isMounted = true;

    const loadData = async () => {
      // ── 1. Show cache instantly ──────────────────────────────────────────
      const cachedData = getCachedMenu(slug);

      if (cachedData) {
        if (isMounted) {
          setData(cachedData);
          setLoading(false);
        }
      } else {
        if (isMounted) setLoading(true);
      }

      // ── 2. Always fetch fresh data in the background ─────────────────────
      try {
        const freshData = await fetchMenuData(slug);

        if (!isMounted) return;

        // ── 3. Update only if data actually changed ──────────────────────
        const hasChanged =
          !cachedData ||
          cachedData.generated_at !== freshData.generated_at;

        if (hasChanged) {
          setData(freshData);
          setCachedMenu(slug, freshData);
        }

        setLoading(false);
        setError(null);
      } catch (err) {
        if (!isMounted) return;

        // Show error only if there's nothing cached to fall back to
        if (!cachedData) {
          setError(err.message || 'An error occurred loading the menu.');
          setLoading(false);
        }
        // If cache exists → visitor still sees valid data, swallow silently
      }
    };

    loadData();

    return () => { isMounted = false; };
  }, [slug]);

  return { data, loading, error };
};
