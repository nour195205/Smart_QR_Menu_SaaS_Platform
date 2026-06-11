import React from 'react';

const ItemCard = ({ item, theme, currencySymbol }) => {
  // Determine card class based on theme config
  const cardStyleClass = theme?.card_style === 'flat' ? 'card-flat' :
                         theme?.card_style === 'shadow' ? 'card-shadow' : 'card-rounded';

  // Advanced settings
  const imgPosition = theme?.advanced_settings?.image_position || theme?.image_position || 'top';
  const isHorizontal = imgPosition === 'left' || imgPosition === 'right';
  
  // Dynamic Inline Styles based on Theme
  const dynamicCardStyle = {
    ...styles.card,
    flexDirection: isHorizontal ? (imgPosition === 'left' ? 'row' : 'row-reverse') : 'column',
    transform: 'var(--card-hover-transform, none)',
    transition: 'transform 0.3s ease',
  };

  const dynamicImageContainerStyle = {
    width: isHorizontal ? '120px' : '100%',
    flexShrink: 0,
    padding: theme?.image_shape === 'circle' ? '16px' : '0',
  };

  const dynamicImageStyle = {
    ...styles.image,
    height: isHorizontal ? '120px' : '200px',
    borderRadius: 'var(--image-shape-radius, 0px)',
    margin: theme?.image_shape === 'circle' && isHorizontal ? 'auto' : '0',
  };

  return (
    <div className={`item-card ${cardStyleClass}`} style={dynamicCardStyle}>
      {item.image_url && (
        <div style={dynamicImageContainerStyle}>
            <img 
            src={item.image_url} 
            alt={item.name} 
            loading="lazy" 
            style={dynamicImageStyle} 
            />
        </div>
      )}
      <div style={styles.content}>
        <div style={styles.header}>
          <h3 style={styles.title}>{item.name}</h3>
          <span style={styles.price}>{currencySymbol}{parseFloat(item.price).toFixed(2)}</span>
        </div>
        
        {item.description && <p style={styles.description}>{item.description}</p>}
        
        {item.tags && item.tags.length > 0 && (
          <div style={{
            ...styles.tags,
            justifyContent: theme?.text_alignment === 'center' ? 'center' : theme?.text_alignment === 'right' ? 'flex-end' : 'flex-start'
          }}>
            {item.tags.map((tag, idx) => (
              <span key={idx} style={styles.tag}>{tag}</span>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

// Base styles relying on CSS vars for colors
const styles = {
  card: {
    backgroundColor: 'var(--card-bg-custom, var(--card-bg))',
    borderRadius: 'var(--card-radius)',
    overflow: 'hidden',
    boxShadow: 'var(--card-shadow)',
    display: 'flex',
    border: '1px solid rgba(0,0,0,0.05)',
  },
  image: {
    width: '100%',
    objectFit: 'cover',
  },
  content: {
    padding: 'var(--spacing-md)',
    display: 'flex',
    flexDirection: 'column',
    gap: 'var(--spacing-sm)',
    textAlign: 'var(--text-align, left)',
    flex: 1,
  },
  header: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    gap: 'var(--spacing-sm)',
  },
  title: {
    fontSize: '1.125rem',
    fontWeight: '600',
    color: 'var(--item-title-color, var(--text-color))',
    lineHeight: '1.4',
  },
  price: {
    fontSize: '1.125rem',
    fontWeight: '700',
    color: 'var(--item-price-color, var(--primary-color))',
    whiteSpace: 'nowrap',
  },
  description: {
    fontSize: '0.875rem',
    color: 'var(--item-desc-color, var(--text-color))',
    opacity: 0.8,
    lineHeight: '1.5',
  },
  tags: {
    display: 'flex',
    flexWrap: 'wrap',
    gap: 'var(--spacing-xs)',
    marginTop: 'var(--spacing-xs)',
  },
  tag: {
    fontSize: '0.75rem',
    padding: '2px 8px',
    backgroundColor: 'var(--primary-color)',
    color: '#fff',
    borderRadius: '12px',
    fontWeight: '500',
  }
};

export default ItemCard;
