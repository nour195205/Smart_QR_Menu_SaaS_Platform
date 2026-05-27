import React from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';
import MenuPage from './pages/MenuPage';

function App() {
  return (
    <BrowserRouter>
      <Routes>
        <Route path="/menu/:slug" element={<MenuPage />} />
        {/* Fallback to a 404 or redirect */}
        <Route path="*" element={
          <div className="container text-center" style={{ marginTop: '20vh' }}>
            <h2>404 - Not Found</h2>
            <p>Please scan a valid restaurant QR code.</p>
          </div>
        } />
      </Routes>
    </BrowserRouter>
  );
}

export default App;
