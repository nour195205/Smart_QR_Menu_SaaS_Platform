import { useEffect } from 'react';

const ThemeInjector = ({ theme }) => {
  useEffect(() => {
    if (!theme) return;

    const root = document.documentElement;

    console.log('Loaded Theme Object:', theme);

    if (theme.primary_color) root.style.setProperty('--primary-color', theme.primary_color);
    if (theme.secondary_color) root.style.setProperty('--secondary-color', theme.secondary_color);
    if (theme.background_color) root.style.setProperty('--bg-color', theme.background_color);
    if (theme.text_color) root.style.setProperty('--text-color', theme.text_color);
    if (theme.category_title_color) root.style.setProperty('--category-title-color', theme.category_title_color);
    if (theme.item_title_color) root.style.setProperty('--item-title-color', theme.item_title_color);
    if (theme.item_description_color) root.style.setProperty('--item-desc-color', theme.item_description_color);
    if (theme.item_price_color) root.style.setProperty('--item-price-color', theme.item_price_color);
    if (theme.card_background_color) root.style.setProperty('--card-bg-custom', theme.card_background_color);
    if (theme.text_alignment) root.style.setProperty('--text-align', theme.text_alignment);
    if (theme.font_family) root.style.setProperty('--font-family', `"${theme.font_family}", sans-serif`);

    // Advanced Settings mapping
    if (theme.animation_speed) {
        const speedMap = { fast: '0.2s', normal: '0.4s', slow: '0.8s' };
        root.style.setProperty('--anim-speed', speedMap[theme.animation_speed] || '0.4s');
    }
    
    // Some variables aren't directly CSS values but logic drivers, 
    // but exposing them as CSS vars helps with generic CSS bindings.
    if (theme.image_shape) root.style.setProperty('--image-shape-radius', theme.image_shape === 'circle' ? '50%' : (theme.image_shape === 'rounded' ? '12px' : '0px'));
    if (theme.card_hover_effect) root.style.setProperty('--card-hover-transform', theme.card_hover_effect === 'lift' ? 'translateY(-4px)' : (theme.card_hover_effect === 'scale' ? 'scale(1.02)' : 'none'));

    if (theme.dark_mode) {
      document.body.classList.add('dark-mode');
    } else {
      document.body.classList.remove('dark-mode');
    }

    return () => {
      // Cleanup not strictly necessary since the theme is global for the slug,
      // but good practice.
      document.body.classList.remove('dark-mode');
    };
  }, [theme]);

  return null; // This component doesn't render anything
};

export default ThemeInjector;
