import React from 'react';

const ItemCard = ({ item, theme, currencySymbol }) => {
  // Determine card class based on theme config
  const cardStyleClass = theme?.card_style === 'flat' ? 'card-flat' :
                         theme?.card_style === 'shadow' ? 'card-shadow' : 'card-rounded';

  return (
    <div className={`item-card ${cardStyleClass}`} style={styles.card}>
      {item.image_url && (
        <img 
          src={item.image_url} 
          alt={item.name} 
          loading="lazy" 
          style={styles.image} 
        />
      )}
      <div style={styles.content}>
        <div style={styles.header}>
          <h3 style={styles.title}>{item.name}</h3>
          <span style={styles.price}>{currencySymbol}{parseFloat(item.price).toFixed(2)}</span>
        </div>
        
        {item.description && <p style={styles.description}>{item.description}</p>}
        
        {item.tags && item.tags.length > 0 && (
          <div style={styles.tags}>
            {item.tags.map((tag, idx) => (
              <span key={idx} style={styles.tag}>{tag}</span>
            ))}
          </div>
        )}
      </div>
    </div>
  );
};

// Inline styles for basic structure, relying on CSS vars for colors
const styles = {
  card: {
    backgroundColor: 'var(--card-bg)',
    borderRadius: 'var(--card-radius)',
    overflow: 'hidden',
    boxShadow: 'var(--card-shadow)',
    display: 'flex',
    flexDirection: 'column',
    border: '1px solid rgba(0,0,0,0.05)',
  },
  image: {
    width: '100%',
    height: '200px',
    objectFit: 'cover',
  },
  content: {
    padding: 'var(--spacing-md)',
    display: 'flex',
    flexDirection: 'column',
    gap: 'var(--spacing-sm)',
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
    color: 'var(--text-color)',
    lineHeight: '1.4',
  },
  price: {
    fontSize: '1.125rem',
    fontWeight: '700',
    color: 'var(--primary-color)',
    whiteSpace: 'nowrap',
  },
  description: {
    fontSize: '0.875rem',
    color: 'var(--text-color)',
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
