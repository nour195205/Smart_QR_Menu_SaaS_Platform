import React from 'react';
import ItemCard from './ItemCard';

const CategorySection = ({ category, theme, currencySymbol }) => {
  // Only render section if it has items
  if (!category.items || category.items.length === 0) return null;

  const layoutClass = theme?.layout_style === 'list' ? 'list-layout' : 'grid-layout';
  const animClass = theme?.animation_style && theme.animation_style !== 'none' ? `anim-${theme.animation_style}` : '';

  return (
    <section id={`category-${category.id}`} className={animClass} style={styles.section}>
      <div style={styles.header}>
        <h2 style={styles.title}>{category.name}</h2>
        {category.description && <p style={styles.description}>{category.description}</p>}
      </div>
      
      <div className={layoutClass}>
        {category.items.map(item => (
          <ItemCard 
            key={item.id} 
            item={item} 
            theme={theme} 
            currencySymbol={currencySymbol} 
          />
        ))}
      </div>
    </section>
  );
};

const styles = {
  section: {
    marginBottom: 'var(--spacing-xl)',
  },
  header: {
    marginBottom: 'var(--spacing-md)',
    paddingBottom: 'var(--spacing-sm)',
    borderBottom: '2px solid var(--primary-color)',
    display: 'inline-block',
  },
  title: {
    fontSize: '1.5rem',
    fontWeight: '700',
    color: 'var(--category-title-color, var(--text-color))',
  },
  description: {
    fontSize: '0.9rem',
    color: 'var(--text-color)',
    opacity: 0.8,
    marginTop: 'var(--spacing-xs)',
  }
};

export default CategorySection;
