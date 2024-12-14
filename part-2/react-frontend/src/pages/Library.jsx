import Navbar from "../components/Navbar";
import "./Library.css";
import { FaRegEye } from "react-icons/fa";
import { RxUpdate } from "react-icons/rx";
import { FaTrash } from "react-icons/fa";
import { FaHandsHelping } from "react-icons/fa";
import { IoIosAddCircle } from "react-icons/io";
import { useContext, useEffect, useState } from "react";
import UserContext from "../components/UserContext";
import axios from "axios";
import { useNavigate } from "react-router-dom";

function Library() {

    const { user } = useContext(UserContext);
    const navigate = useNavigate();

    const [books, setBooks] = useState([]);


    useEffect(() => {
      
      // get books from the server with authorization token
      axios.get("http://localhost:8000/api/books/", {
        headers: {
          Authorization: `Bearer ${JSON.parse(user).token}`
        }
      }).then(response => {
        setBooks(response.data);
      }
      ).catch(error => {
        console.log(error);
      }
      );

    }, [user]);

    function SearchTab() {
        return (
          <section className="search-tab">
            <button className="add-book-button" onClick={() => navigate("/createbook")}> Add Book </button>
            <button className="add-book-button" onClick={() => navigate("/createmember")}> Add Member </button>
            <input type="text" placeholder="Search books" className="search-input" />
            <select className="search-filter">
                <option value="all">All</option>
                <option value="title">Title</option>
                <option value="author">Author</option>
            </select>
          </section>
        );
    }

    function Book( {book} ) {
        return (
          <div className="book-container">
              <div className="book-details">
                <div className="book-middle-row">
                    <h3> {book.name} </h3>
                    <p> {book.author.name} </p>
                </div>
                <div className="book-bottom-row">
                    <p>ISBN: {book.isbn}</p>
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
            { books && books.map(book => <Book key={book.id} book={book} />) }
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
                <h1 className="library-heading">Library</h1>
                <SearchTab />
                <BookList />
            </div>
          </main>
    
        </>
      );

}

export default Library;