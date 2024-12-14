import { useState } from "react";
import Navbar from "../components/Navbar";
import axios from "axios";
import { useContext, useEffect } from "react";
import UserContext from "../components/UserContext";
import { useNavigate } from "react-router-dom";

function CreateBook() {

    const { user } = useContext(UserContext);
    const navigate = useNavigate();

    const [bookDetails, setBookDetails] = useState({
        name: "",
        isbn: "",
        description: "",
        genre_id: "",
        author_id: "",
    });

    const [genres, setGenres] = useState([]);
    const [authors, setAuthors] = useState([]);

    const getGenres = async () => {

        try {
            axios.get("http://localhost:8000/api/genres/", {
                headers: {
                  Authorization: `Bearer ${JSON.parse(user).token}`
                }
              }).then(response => {
                setGenres(response.data);
              }).catch(error => {
                console.log(error);
              }
            );
        } catch (error) {
            console.log(error);
        }

    }

    const getAuthors = async () => {

        try {
            axios.get("http://localhost:8000/api/authors/", {
                headers: {
                  Authorization: `Bearer ${JSON.parse(user).token}`
                }
              }).then(response => {
                setAuthors(response.data);
              }).catch(error => {
                console.log(error);
              }
            );
        } catch (error) {
            console.log(error);
        }

    }

    useEffect(() => {
        
        if (user) {
            getGenres();
            getAuthors();
        }

    }, [user]);

    useEffect(() => {
        console.log(bookDetails);
    }, [bookDetails]);

    const submitDetails = async (e) => {
        
        e.preventDefault();

        try {
            axios.post("http://localhost:8000/api/books/", bookDetails, {
                headers: {
                  Authorization: `Bearer ${JSON.parse(user).token}`
                }
              }).then(response => {
                navigate("/library");
              }).catch(error => {
                console.log(error);
              }
            );
        }
        
        catch (error) {
            console.log(error);
        }

    }

    return (
        <>
        <header>
            <Navbar />
        </header>

        <main className="main-login">
            <div className="login-container">
                <h1>Create Book</h1>
                <form onSubmit={submitDetails}>
                    <div className="form-group">
                        <label htmlFor="bookName">Book Name</label>
                        <input 
                            type="text" 
                            id="bookName" 
                            name="bookName" 
                            required 
                            onChange={(e) => setBookDetails({...bookDetails, name: e.target.value})} 
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="isbn">ISBN</label>
                        <input 
                            type="text" 
                            id="isbn" 
                            name="isbn" 
                            required 
                            onChange={(e) => setBookDetails({...bookDetails, isbn: e.target.value})} 
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="description">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            required 
                            onChange={(e) => setBookDetails({...bookDetails, description: e.target.value})} 
                        ></textarea>
                    </div>
                    <div className="form-group">
                        <label htmlFor="genre">Genre</label>
                        <select 
                            id="genre" 
                            name="genre" 
                            required 
                            onChange={(e) => setBookDetails({ ...bookDetails, genre_id: e.target.value })}
                        >
                            <option value="">Select Genre</option>
                            {genres.map((genre) => (
                                <option key={genre.genre_id} value={genre.genre_id}>
                                    {genre.name}
                                </option>
                            ))}
                        </select>
                    </div>

                    <div className="form-group">
                        <label htmlFor="author">Author</label>
                        <select 
                            id="author" 
                            name="author" 
                            required 
                            onChange={(e) => setBookDetails({ ...bookDetails, author_id: e.target.value })}
                        >
                            <option value="">Select Author</option>
                            {authors.map((author) => (
                                <option key={author.author_id} value={author.author_id}>
                                    {author.name}
                                </option>
                            ))}
                        </select>
                    </div>
                    <button type="submit">Create Book</button>
                </form>
            </div>
        </main>
        </>
    );
}

export default CreateBook;