import React, { useState } from 'react';
import { Document, Page, pdfjs } from 'react-pdf';
import 'react-pdf/dist/Page/AnnotationLayer.css';
import 'react-pdf/dist/Page/TextLayer.css';

// Configure the worker for pdfjs
pdfjs.GlobalWorkerOptions.workerSrc = new URL(
  'pdfjs-dist/build/pdf.worker.min.mjs',
  import.meta.url,
).toString();

const PdfViewer = ({ pdfUrl }) => {
  const [numPages, setNumPages] = useState(null);
  const [error, setError] = useState(null);

  if (!pdfUrl) return null;

  // For local testing without Cloudinary, proxy the URL to bypass CORS
  const fetchUrl = pdfUrl.startsWith('http://127.0.0.1:8000') 
    ? pdfUrl.replace('http://127.0.0.1:8000', '') 
    : pdfUrl;

  function onDocumentLoadSuccess({ numPages }) {
    setNumPages(numPages);
  }
  
  function onDocumentLoadError(err) {
    console.error("PDF Load Error:", err);
    setError(err.message);
  }

  return (
    <div style={styles.container}>
      {error && (
        <div style={styles.fallback}>
          <p>We couldn't load the embedded PDF natively.</p>
          <a href={pdfUrl} target="_blank" rel="noopener noreferrer" style={styles.button}>
            Open PDF Menu
          </a>
        </div>
      )}
      
      {!error && (
        <Document
          file={fetchUrl}
          onLoadSuccess={onDocumentLoadSuccess}
          onLoadError={onDocumentLoadError}
          loading={
            <div style={styles.loading}>
              <div className="spinner" style={{margin: '0 auto 16px auto'}}></div>
              <p>Loading Menu...</p>
            </div>
          }
        >
          {Array.from(new Array(numPages), (el, index) => (
            <div key={`page_${index + 1}`} style={styles.pageContainer}>
              <Page
                pageNumber={index + 1}
                renderTextLayer={false}
                renderAnnotationLayer={false}
                width={Math.min(window.innerWidth - 32, 800)} // Responsive width
              />
            </div>
          ))}
        </Document>
      )}
    </div>
  );
};

const styles = {
  container: {
    width: '100%',
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    backgroundColor: 'transparent',
  },
  pageContainer: {
    marginBottom: '16px',
    boxShadow: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)',
    borderRadius: '8px',
    overflow: 'hidden',
  },
  loading: {
    padding: '40px',
    textAlign: 'center',
    color: 'var(--text-color)',
    opacity: 0.7,
  },
  fallback: {
    display: 'flex',
    flexDirection: 'column',
    alignItems: 'center',
    justifyContent: 'center',
    padding: '40px',
    textAlign: 'center',
  },
  button: {
    marginTop: '16px',
    display: 'inline-block',
    padding: '12px 24px',
    backgroundColor: 'var(--primary-color, #FF6B35)',
    color: '#fff',
    textDecoration: 'none',
    borderRadius: '8px',
    fontWeight: 'bold',
  }
};

export default PdfViewer;
