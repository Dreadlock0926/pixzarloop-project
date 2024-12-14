import Navbar from "../components/Navbar";
import "./Library.css";

import { FaRegEye } from "react-icons/fa";
import { RxUpdate } from "react-icons/rx";
import { FaTrash } from "react-icons/fa";
import { FaHandsHelping } from "react-icons/fa";

function Library() {

    function SearchTab() {
        return (
          <section className="search-tab">
            <input type="text" placeholder="Search books" className="search-input" />
            <select className="search-filter">
                <option value="all">All</option>
                <option value="title">Title</option>
                <option value="author">Author</option>
            </select>
          </section>
        );
    }

    function Book() {
        return (
          <div className="book-container">
              <div className="book-details">
                <div className="book-middle-row">
                    <h3>Book Title</h3>
                    <p>Author</p>
                </div>
                <div className="book-bottom-row">
                    <p>ISBN: 1234567890</p>
                </div>
              </div>
              <div className="book-actions">
                <FaRegEye className="action-icon" />
                <RxUpdate className="action-icon" />
                <FaTrash className="action-icon" />
                <FaHandsHelping className="action-icon" />
              </div>
          </div>
        );
    }

    function BookList() {
        return (
          <section className="book-list">
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
            <Book />
          </section>
        );
      }

    return (
        <>
    
          <header>
            <Navbar />  
          </header>
    
          <main>
            <div className="library-container">
                <SearchTab />
                <BookList />
            </div>
          </main>
    
        </>
      );

}

export default Library;