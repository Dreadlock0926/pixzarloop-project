import { useState } from 'react'
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom'
import Borrowings from './pages/Borrowings'
import Library from './pages/Library'
import './index.css'
import Login from './pages/Login'
import CreateBook from './pages/CreateBook'
import CreateMember from './pages/CreateMember'

function App() {

  return (
    <Router>
      <Routes>
        <Route path="/" element={<Login />} />
        <Route path="/createbook" element={<CreateBook />} />
        <Route path="/createmember" element={<CreateMember />} />
        <Route path="/library" element={<Library />} />
        <Route path="/borrowings" element={<Borrowings />} />
      </Routes>
    </Router>
  )

}

export default App;
