import { useState, useEffect } from 'react';
import { fetchMenuData } from '../services/api';
import { getCachedMenu, setCachedMenu } from '../utils/cache';

export const useMenuData = (slug) => {
  const [data, setData] = null;
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    if (!slug) return;

    let isMounted = true;

    const loadData = async () => {
      try {
        // 1. Check local cache first for instant render
        const cachedData = getCachedMenu(slug);
        
        if (cachedData) {
          if (isMounted) {
            setData(cachedData);
            setLoading(false); // Instantly loaded from cache!
          }
        } else {
          if (isMounted) setLoading(true);
        }

        // 2. Fetch fresh data in the background (Stale-While-Revalidate)
        const freshData = await fetchMenuData(slug);
        
        if (isMounted) {
          // If we had cache, we only update state if the updated_at timestamp changed
          // to prevent unnecessary re-renders.
          const isUpdated = !cachedData || cachedData.updated_at !== freshData.updated_at;
          
          if (isUpdated) {
            setData(freshData);
            setCachedMenu(slug, freshData);
          }
          
          setLoading(false);
          setError(null);
        }
      } catch (err) {
        if (isMounted) {
          // Only show error if we don't have cached data to fallback to
          if (!getCachedMenu(slug)) {
            setError(err.message || 'An error occurred loading the menu.');
            setLoading(false);
          }
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
