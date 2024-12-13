import { useState } from 'react'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import Borrowings from './pages/Borrowings'
import './index.css'

function App() {

  return (
    <Router>
      <Routes>
        <Route path="/borrowings" element={<Borrowings />} />
      </Routes>
    </Router>
  )

}

export default App;
