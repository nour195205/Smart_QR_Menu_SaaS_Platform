import React from 'react';

const PdfViewer = ({ pdfUrl }) => {
  if (!pdfUrl) return null;

  return (
    <div style={styles.container}>
      <object 
        data={pdfUrl} 
        type="application/pdf" 
        style={styles.viewer}
      >
        <div style={styles.fallback}>
          <p>Your browser doesn't support embedded PDFs.</p>
          <a href={pdfUrl} target="_blank" rel="noopener noreferrer" style={styles.button}>
            Download PDF Menu
          </a>
        </div>
      </object>
    </div>
  );
};

const styles = {
  container: {
    width: '100%',
    height: 'calc(100vh - 150px)', // Adjust based on header height
    minHeight: '500px',
    backgroundColor: '#f5f5f5',
    borderRadius: '8px',
    overflow: 'hidden',
    border: '1px solid #ddd',
  },
  viewer: {
    width: '100%',
    height: '100%',
    border: 'none',
  },
  fallback: {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center',
    height: '100%',
    padding: '20px',
    textAlign: 'center',
  },
  button: {
    marginTop: '16px',
    display: 'inline-block',
    padding: '10px 20px',
    backgroundColor: 'var(--primary-color, #FF6B35)',
    color: '#fff',
    textDecoration: 'none',
    borderRadius: '4px',
    fontWeight: 'bold',
  }
};

export default PdfViewer;
