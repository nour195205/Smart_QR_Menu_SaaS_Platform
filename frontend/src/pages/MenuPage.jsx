import React from 'react';
import { useParams } from 'react-router-dom';
import { useMenuData } from '../hooks/useMenuData';
import ThemeInjector from '../components/ThemeInjector';
import CategorySection from '../components/CategorySection';
import PdfViewer from '../components/PdfViewer';

const MenuPage = () => {
  const { slug } = useParams();
  const { data, loading, error } = useMenuData(slug);

  if (loading) {
    return (
      <div className="loading-container">
        <div className="spinner"></div>
        <p>Loading menu...</p>
      </div>
    );
  }

  if (error || !data) {
    return (
      <div className="container text-center" style={{ marginTop: '20vh' }}>
        <h2>Menu Not Found</h2>
        <p style={{ color: 'var(--text-color)', opacity: 0.7, marginTop: '8px' }}>
          {error || "We couldn't find a menu for this restaurant."}
        </p>
      </div>
    );
  }

  const { restaurant, theme, menu_type, pdf_menu, categories } = data;

  return (
    <>
      <ThemeInjector theme={theme} />
      
      <div className="container">
        {/* Restaurant Header */}
        <header style={styles.header}>
          {restaurant.logo_url && (
            <img src={restaurant.logo_url} alt={`${restaurant.name} logo`} style={styles.logo} />
          )}
          <h1 style={styles.title}>{restaurant.name}</h1>
          {restaurant.description && <p style={styles.description}>{restaurant.description}</p>}
        </header>

        {/* Content based on Menu Type */}
        <main style={styles.main}>
          {menu_type === 'pdf' && pdf_menu ? (
            <PdfViewer pdfUrl={pdf_menu.file_url} />
          ) : (
            <div>
              {categories && categories.length > 0 ? (
                categories.map(category => (
                  <CategorySection 
                    key={category.id} 
                    category={category} 
                    theme={theme}
                    currencySymbol={restaurant.currency_symbol || '$'} 
                  />
                ))
              ) : (
                <p className="text-center">This menu is currently empty.</p>
              )}
            </div>
          )}
        </main>
        
        {/* Footer */}
        <footer style={styles.footer}>
          <p>Powered by <strong>Smart QR Menu</strong></p>
        </footer>
      </div>
    </>
  );
};

const styles = {
  header: {
    padding: 'var(--spacing-xl) 0 var(--spacing-lg)',
    textAlign: 'center',
    borderBottom: '1px solid rgba(0,0,0,0.1)',
  },
  logo: {
    height: '80px',
    width: 'auto',
    marginBottom: 'var(--spacing-md)',
    borderRadius: '8px',
    objectFit: 'contain',
  },
  title: {
    fontSize: '2rem',
    fontWeight: '700',
    marginBottom: 'var(--spacing-xs)',
  },
  description: {
    color: 'var(--text-color)',
    opacity: 0.8,
  },
  main: {
    padding: 'var(--spacing-xl) 0',
  },
  footer: {
    padding: 'var(--spacing-xl) 0',
    textAlign: 'center',
    color: 'var(--text-color)',
    opacity: 0.5,
    fontSize: '0.875rem',
  }
};

export default MenuPage;
