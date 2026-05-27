const CACHE_EXPIRY_MS = 1000 * 60 * 60 * 24; // 24 hours

export const getCachedMenu = (slug) => {
  try {
    const cachedStr = localStorage.getItem(`menu_${slug}`);
    if (!cachedStr) return null;

    const parsed = JSON.parse(cachedStr);
    
    // Check if cache has expired (optional, but good practice)
    if (Date.now() - parsed.timestamp > CACHE_EXPIRY_MS) {
      return null;
    }
    
    return parsed.data;
  } catch (e) {
    console.warn('Failed to parse cached menu', e);
    return null;
  }
};

export const setCachedMenu = (slug, data) => {
  try {
    const payload = {
      timestamp: Date.now(),
      data
    };
    localStorage.setItem(`menu_${slug}`, JSON.stringify(payload));
  } catch (e) {
    console.warn('Failed to save menu to cache', e);
  }
};
