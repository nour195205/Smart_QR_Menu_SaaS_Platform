import { useEffect } from 'react';

const ThemeInjector = ({ theme }) => {
  useEffect(() => {
    if (!theme) return;

    const root = document.documentElement;

    if (theme.primary_color) root.style.setProperty('--primary-color', theme.primary_color);
    if (theme.secondary_color) root.style.setProperty('--secondary-color', theme.secondary_color);
    if (theme.background_color) root.style.setProperty('--bg-color', theme.background_color);
    if (theme.text_color) root.style.setProperty('--text-color', theme.text_color);
    if (theme.font_family) root.style.setProperty('--font-family', `"${theme.font_family}", sans-serif`);

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
